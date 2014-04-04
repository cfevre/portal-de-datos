<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nav extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('mantencion');

		parent::__construct();
		$this->loadScript('page', site_url('assets/js/backend/navitem.js'));	
	}
	
	public function index() {
		$this->loadData('navs', $this->doctrine->em->getRepository('Entities\Nav')->findAll());

		$this->loadBlock('content', 'backend/nav/list', $this->data);

		$this->renderView('backend/layout');
	}

	public function add(){
		$this->_load_nav_form(new Entities\Nav);
	}

	public function edit($navId){
		$this->_load_nav_form($this->doctrine->em->find('Entities\Nav', $navId), false);
	}

	public function update(){
		$this->_store_nav($this->doctrine->em->find('Entities\Nav', $this->input->post('id', true)), false);
	}

	public function create(){
		$this->_store_nav(new Entities\Nav);
	}

	/*
	* Nav Items
	*/

	public function deleteitem($navItemId){
		$navItem = $this->doctrine->em->find('Entities\NavItem', $navItemId);
		$nav = $this->_findNav($navItem);

		$this->doctrine->em->remove($navItem);
		$this->doctrine->em->flush();

		redirect('backend/nav/edit/'.$nav->getId());
	}

	public function additem($navId){
		$nav = $this->doctrine->em->find('Entities\Nav', $navId);
		$navItem = new Entities\NavItem;
		$navItem->setNav($nav);
		$this->_load_nav_item_form($nav, $navItem);
	}

	public function edititem($navItemId){
		$navItem = $this->doctrine->em->find('Entities\NavItem', $navItemId);
		$nav = $this->_findNav($navItem);
		$this->_load_nav_item_form($nav, $navItem, false);
	}

	public function updateitem(){
		$navItem = $this->doctrine->em->find('Entities\NavItem', $this->input->post('id', true));
		$nav = $this->_findNav($navItem);
		$this->_store_nav_item($nav, $navItem, false);
	}

	public function createitem(){
		$nav = $this->doctrine->em->find('Entities\Nav', $this->input->post('nav_id', true));
		$this->_store_nav_item($nav, new Entities\NavItem);
	}

	/*
	* Helper to strore the nav on the database
	*/
	function _store_nav($nav, $newNav = true){
		$alias = stringsHelper::sanitize_string($this->input->post('alias', true));
		if(!$alias)
			$alias = stringsHelper::sanitize_string($this->input->post('title', true));

		$nav->setTitle($this->input->post('title', true));
		$nav->setPosition($this->input->post('position', true));
		$nav->setAlias($alias);

		if(!$nav->getTitle())
			$this->addMessage('Debe ingresar un título para el menú.');

		if($this->error){
			$this->_load_nav_form($nav, $newNav);
		}else{
			$this->doctrine->em->persist($nav);
			$this->doctrine->em->flush();

			redirect('backend/nav');
		}
	}

	/*
	* Helper to find the nav of the item
	*/
	function _findNav($item){
		while (!$item->getNav()) {
			$item = $item->getParent();
		}
		return $item->getNav();
	}

	/*
	* Helper to load the nav form view
	*/
	function _load_nav_form($nav, $newNav = true){
		$this->loadData('formAction', $newNav?site_url('backend/nav/create'):site_url('backend/nav/update'));
		$this->loadData('nav', $nav);

		$this->loadBlock('content', 'backend/nav/form', $this->data);

		$this->renderView('backend/layout');
	}

	function _store_nav_item($nav, $navItem, $newNavItem = true){
		
		$parentNavItem = $this->doctrine->em->find('Entities\NavItem', $this->input->post('parentNavItem', true));
		$page = $this->doctrine->em->find('Entities\Page', $this->input->post('page_id', true));

		$alias = stringsHelper::sanitize_string($this->input->post('alias', true));
		if(!$alias)
			$alias = stringsHelper::sanitize_string($this->input->post('title', true));

		$homepage = $this->input->post('homepage', true);
		if($homepage){
			$prevNavItemHome = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('homepage'=>true));

			if($prevNavItemHome != $navItem && $prevNavItemHome){
				$prevNavItemHome->setHomepage(false);
				$this->doctrine->em->persist($prevNavItemHome);
			}

		}

		$customurl = $this->input->post('customurl', true);

		if(!$customurl){
			$navItem->setPage($page);
			$navItem->setCustomurl(null);
		}else{
			$navItem->setPage(null);
			$navItem->setCustomurl($customurl);
		}

		$navItem->setTitle($this->input->post('title', true));
		$navItem->setAlias($alias);
		$navItem->setLayout($this->input->post('layout', true));
		$navItem->setHomepage($homepage);
		$navItem->setOrdering($this->input->post('ordering', true));
		$navItem->setTarget($this->input->post('target', true));

		if($parentNavItem){
			$navItem->setParent($parentNavItem);
			$navItem->setNav(null);
		}else{
			$navItem->setNav($nav);
			$navItem->setParent(null);
		}

		if(!$navItem->getTitle())
			$this->addMessage('Debe ingresar un título para el item.');

		if(!$navItem->getLayout() && $navItem->getPage())
			$this->addMessage('Debe seleccionar un layout para el menú cuando elige una pagina asociada.');

		if($this->error){
			$this->_load_nav_item_form($nav, $navItem, $newNavItem);
		}else{
			$this->doctrine->em->persist($navItem);
			$this->doctrine->em->flush();

			redirect('backend/nav/edit/'.$nav->getId());
		}
	}

	/*
	* Helper to load the nav item form view
	*/
	function _load_nav_item_form($nav, $navItem, $newNavItem = true){
		$this->loadData('formAction', $newNavItem?site_url('backend/nav/createitem'):site_url('backend/nav/updateitem'));
		$this->loadData('nav', $nav);
		$this->loadData('navItem', $navItem);

		$this->loadData('navItemList', $this->_generateNavItemList($nav, $navItem));
		$this->loadData('layoutList', $this->_generateLayoutList($this->getLayouts('page/layouts'), $navItem->getLayout()));
		$this->loadData('pagesList', $this->_generatePagesList($navItem));

		$this->loadBlock('content', 'backend/nav/item/form', $this->data);

		$this->renderView('backend/layout');
	}

	/*Ajax Calls*/
	public function togglePublicado($navItemId = null){
		if(!$this->isAjax())
			return false;
		if(!$navItemId)
			$navItemId = $this->input->get('id', true);

		$navItem = $this->doctrine->em->find('Entities\NavItem', $navItemId);

		$navItem->setPublished(!$navItem->getPublished());

		if($navItem->getPublished())
			$navItem->setPublishedAt(new DateTime());

		$this->doctrine->em->persist($navItem);
		$this->doctrine->em->flush();

		$callback = 'navitem.updatePublicadoButton('.$navItemId.','.($navItem->getPublished()?'true':'false').')';

		echo json_encode(array(
			'error' => false,
			'message' => 'Estado de publicación actualizado',
			'callback' => $callback
		));

		return true;
	}
	/*
	* HTML Helpers
	*/

	function _generateLayoutList($layouts, $activeLayout){
		$list = '<select id="layout" name="layout"><option value="">- Seleccione -</option>';
		foreach ($layouts as $key => $layout) {
			$selected = $layout==$activeLayout ? ' selected="selected"':'';
			$list .= '<option'.$selected.' value="'.$layout.'">'.ucfirst($layout).'</option>';
		}
		$list .= '</select>';
		return $list;
	}

	function _generateNavItemList($nav, $activeNavItem){
		$list = '<select id="parentNavItem" name="parentNavItem"><option value="">- Seleccione -</option>';

		foreach ($nav->getItems() as $key => $navItem) {
			$list .= $this->_getNavItemTree($navItem, $activeNavItem);
		}

		$list .= '</select>';

		return $list;
	}

	 function _generatePagesList($navItem){
		$pages = $this->doctrine->em->getRepository('Entities\Page')->findAll();
		$list = '<select id="page_id" name="page_id"><option value="">- Seleccione -</option>';
		foreach($pages as $page){
			$selected = $page == $navItem->getPage() ? ' selected="selected"' : '';
			$list .= '<option'.$selected.' value="'.$page->getId().'">'.$page->getTitle().'</option>';
		}
		$list .= '</select>';
		return $list;
	}

	function _getNavItemTree($navItem, $activeNavItem, $level = 0){
		$selected = $activeNavItem->getParent() == $navItem ? ' selected="selected"' : '';
		$list = '<option'.$selected.' value="'.$navItem->getId().'">'.str_repeat('|--',$level).$navItem->getTitle().'</option>';
		if($navItem->getChildren()){
			foreach ($navItem->getChildren() as $key => $subItem) {
				$list .= $this->_getNavItemTree($subItem, $activeNavItem, $level+1);
			}
		}
		return $list;
	}
}
