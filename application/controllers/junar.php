<?php
	/**
	* Junar Controller
	*/
	class Junar extends CIE_Controller{
		public function dashboard(){
			
		}

		public function header(){
			$this->enableCache();
			$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('alias'=>'dashboard'));
			
			$this->loadData('navItem', $navItem);

			$this->loadNavs();
			$this->loadBreadcrumb($this->data);
			$this->setPageTitle('Header Junar');

			$this->renderView('junar/header');
		}

		public function footer(){
			$this->enableCache();
			$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('alias'=>'dashboard'));
			
			$this->loadData('navItem', $navItem);

			$this->loadNavs();
			$this->loadBreadcrumb($this->data);
			$this->setPageTitle('Footer Junar');

			$this->renderView('junar/footer');
		}
	}
?>