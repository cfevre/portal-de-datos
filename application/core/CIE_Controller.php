<?php
	/**
	* 
	*/
	class CIE_Controller extends CI_Controller{

		var $user = null;

		var $error = false;
		
		var $blocks = array(
				'main_menu' => '',
				'side_menu' => '',
				'footer_menu' => '',
				'breadcrumb' => '',
				'content' => ''
			);
		var $data = array(
				'page_title' => 'Portal de Datos Públicos - ',
				'navItem' => null
			);
		var $scripts = array();

		var $stylesheets = array();

		var $messages = array();
		
		var $sectionRols = array();

		function __construct(){
		
			parent::__construct();

			$sessionUser = $this->session->userdata('user');

			if($sessionUser){

				$this->user = $this->doctrine->em->find('Entities\User', $sessionUser['id']);
				$this->loadData('user', $this->user);

				$this->checkUserAccess();

			}else{

				if(count($this->sectionRols) > 0 || strpos(current_url(), 'backend')){
					$this->addMessage('Debe iniciar sesión para poder ingresar.');
					$this->session->set_userdata('refering_url', current_url());
					redirect('auth');
				}

			}

		}

		public function enableCache(){
			if($this->config->item('cache'))
				$this->output->cache($this->config->item('cache'));
		}

		public function checkUserAccess(){
			if(!$this->user->hasRol($this->sectionRols)){
				$this->addMessage('Debe tener permiso para ingresar esta sección del sitio.');
				$this->session->set_userdata('refering_url', current_url());
				if(strpos(current_url(), 'backend'))
					redirect('backend');
				else
					redirect('');
			}
		}

		public function addMessage($message, $type = 'error'){
			if($type == 'error')
				$this->error = true;
			$this->messages[] = array('type' => $type, 'message' => $message);
			$this->session->set_userdata('messages', $this->messages);
		}

		public function loadMessages(){
			$this->messages = $this->session->userdata('messages');
			$this->loadBlock('messages', 'messages/view', array('messages' => $this->messages));
			$this->session->unset_userdata('messages');
		}

		public function loadNavs(){
			$navs_position_path = './application/views/nav/positions/';
			$navs = $this->doctrine->em->getRepository('Entities\Nav')->findAll();
			$this->loadData('navs', $navs);
			foreach($navs as $nav){
				$this->loadData('nav', $nav);
				$positions = explode(',', trim($nav->getPosition()));
				foreach($positions as $position){
					$position_template = file_exists($navs_position_path.$position.'.php')?$position:'default';
					$this->loadBlock($position, 'nav/positions/'.$position_template, $this->data);
				}
			}
		}

		public function loadData($name, $data){
			$this->data[$name] = $data;
		}

		public function addBlock($position, $content){
			$this->blocks[$position][] = $content;
		}

		public function loadBlock($position = 'content', $view, $data = null){
			if(isset($this->blocks[$position]) && $this->blocks[$position])
				$this->blocks[$position] .= $this->load->view($view, $data, true);
			else
				$this->blocks[$position] = $this->load->view($view, $data, true);
		}

		public function loadBreadcrumb($data, $extra_crumbs = null){
			if($extra_crumbs)
				$extra_crumbs = array_reverse($extra_crumbs);
			
			$data['extra_crumbs'] = $extra_crumbs;
			$this->blocks['breadcrumb'] = $this->load->view('nav/breadcrumb', $data, true);
		}

		public function loadScript($name, $url){
			$this->scripts[$name] = $url;
		}

		public function loadStylesheet($name, $url){
			$this->stylesheets[$name] = $url;
		}

		public function setPageTitle($page_title){
			$this->data['page_title'] .= $page_title;
		}

		public function isAjax($showMsg = false){
			if(!$this->input->is_ajax_request()){
				if($showMsg)
					echo 'Only ajax requests allowed.';
				return false;
			}else{
				return true;
			}
		}

		public function renderView($view){
			if($this->isAjax()){
				$this->load->view($view, $this->data);
			}else{
				$this->loadMessages();
				
				$data['blocks'] = $this->blocks;
				$data['data'] = $this->data;
				$data['scripts'] = $this->scripts;
				$data['stylesheets'] = $this->stylesheets;

				$this->load->view($view, $data);
			}
		}

		public function checkAccess(){
			if(!isset($this->data['page']))
				return false;
			if($this->data['page']->getRestricted() && !$this->user){
				$this->addMessage('Debe iniciar sesión para poder ingresar.');
				redirect('auth');
			}
		}

		public function getLayouts($path){
			$this->load->helper('file');
			$layouts = get_filenames('./application/views/'.$path.'/');
			foreach ($layouts as &$layout) {
				$layout = str_replace('.php', '', $layout);
			}
			return $layouts;
		}

        public function get_post($param = '', $default = '')
        {
            return $this->input->get_post($param, true)?$this->input->get_post($param, true):$default;
        }
	}
?>