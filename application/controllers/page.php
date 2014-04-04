<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CIE_Controller {

	public function __construct(){
		parent::__construct();
		$this->enableCache();
	}

	public function index(){
		$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('homepage'=>true));
		$this->view($navItem->getAlias());
	}

	public function view($alias = null){
		$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('alias'=>$alias));
		
		$this->loadData('navItem', $navItem);
		if(!$navItem){
			show_404('El dataset no ha sido encontrado.');
		}else{
				
			if($navItem->getPage()){
				$this->loadData('page',$navItem->getPage());

				$this->setPageTitle($this->data['page']->getTitle());

				$this->checkAccess();

			}

			if($navItem->getHomepage()){
				$this->addBlock('home-main', widgetHelper::catalogosTop());
				$this->addBlock('home-side', widgetHelper::junarDestacados());
			}

			$this->loadBlock('content', 'page/layouts/'.$navItem->getLayout(), $this->data);
			$this->loadNavs();
			$this->loadBreadcrumb($this->data);

			$this->renderView('layout');
		}
	}

}
