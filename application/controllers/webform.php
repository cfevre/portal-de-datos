<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webform extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->view('default');
	}

	public function view($alias){
		$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl' => current_url()));
		$nav = $this->doctrine->em->find('Entities\Nav', 1);

		$this->loadData('navItem', $navItem);
		$this->loadData('nav', $nav);
		$this->loadData('formAction', 'webform/postform');

		$this->setPageTitle($navItem->getTitle());

		$this->loadBlock('side_menu', 'nav/side_menu', $this->data);
		$this->loadBlock('content', 'webform/'.$alias, $this->data);

		$this->renderView('layout');
	}

	public function postform(){
		$webform = new Entities\WebForm;

		$webform->setCampo($this->input->post('campo'));
		$webform->setCreated(new DateTime());

		$this->doctrine->em->persist($page);
		$this->doctrine->em->flush();

		redirect('backend/page');
	}

}
