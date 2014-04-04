<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('cms');

		parent::__construct();

		$this->loadScript('page', site_url('assets/js/backend/page.js'));
		
	}
	
	public function index() {
		$this->loadData('pages', $this->doctrine->em->getRepository('Entities\Page')->findAll());

		$this->loadBlock('content', 'backend/page/list', $this->data);

		$this->renderView('backend/layout');
	}

	public function delete($pageId){
		$page = $this->doctrine->em->find('Entities\Page', $pageId);
		$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('page' => $page));
		if(!$navItem){
			$this->doctrine->em->remove($page);
			$this->doctrine->em->flush();
		}else{
			$this->addMessage('No es posible eliminar la página, ya que está asociada a un item de menú.');
		}
		redirect('backend/page');
	}

	public function edit($pageId){
		$this->load_page_form($this->doctrine->em->find('Entities\Page', $pageId), false);
	}

	public function add(){
		$this->load_page_form(new Entities\Page);
	}

	public function update(){
		$this->store_page($this->doctrine->em->find('Entities\Page', $this->input->post('id', true)), false);
	}

	public function create(){
		$this->store_page(new Entities\Page);
	}

	/*
	* Helper to strore the page on the database
	*/
	function store_page($page, $newPage = true){
		$alias = stringsHelper::sanitize_string($this->input->post('alias', true));
		if(!$alias)
			$alias = stringsHelper::sanitize_string($this->input->post('title', true));

		$page->setTitle($this->input->post('title', true));
		$page->setAlias($alias);
		$page->setRestricted($this->input->post('restricted'), true);
		$page->setContent($this->input->post('content'));

		if(!$page->getTitle()){
			$this->addMessage('Debe ingresar un título para la página.');
		}

		if($this->error){
			$this->load_page_form($page, $newPage);
		}else{
			$this->doctrine->em->persist($page);
			$this->doctrine->em->flush();

			redirect('backend/page');
		}
	}

	/*
	* Helper to load the page form view
	*/
	function load_page_form($page, $newPage = true){
		$this->loadData('formAction', $newPage?site_url('backend/page/create'):site_url('backend/page/update'));
		$this->loadData('page', $page);

		$this->loadBlock('content', 'backend/page/form', $this->data);

		$this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
		$this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));

		$this->renderView('backend/layout');
	}

	/*Ajax Calls*/
	public function toggleRestricted(){
		if(!$this->isAjax())
			return false;
		$pageId = $this->input->get('id', true);
		$page = $this->doctrine->em->find('Entities\Page', $pageId);

		$page->setRestricted(!$page->getRestricted());

		$this->doctrine->em->persist($page);
		$this->doctrine->em->flush();

		$callback = 'page.updateRestrictedButton('.$pageId.','.($page->getRestricted()?'true':'false').')';

		echo json_encode(array(
			'error' => false,
			'message' => 'Estado de restricción actualizado',
			'callback' => $callback
		));

		return true;
	}
}
