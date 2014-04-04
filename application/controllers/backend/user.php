<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CIE_Controller {

	function __construct(){

		parent::__construct();

        $this->loadScript('page', site_url('assets/js/backend/users.js'));
		
	}
	
	public function index() {
		$this->sectionRols = array('mantencion');
		$options = array();
		$this->checkUserAccess();

		$this->load->library('pagination');

		$limit = 20;

		$orderby = $this->input->get('orderby', true) ? $this->input->get('orderby', false) : 'id';
		$orderdir = $this->input->get('orderdir', true) ? $this->input->get('orderdir', false) : 'desc';
		$offset = $this->input->get('offset', true) ? $this->input->get('offset', true) : 0;
		$rol = $this->input->get('rol', true) ? $this->input->get('rol', true) : '';
        $fullname = $this->input->get('fullname', true) ? $this->input->get('fullname', true) : '';
        $servicio = $this->input->get('servicio', true) ? $this->input->get('servicio', true) : '';

		if($rol)
			$options['rol'] = $rol;

        if($fullname)
            $options['fullname'] = $fullname;

        if($servicio)
            $options['servicio'] = $servicio;

		$count = $this->doctrine->em->getRepository('Entities\User')->findWithOrdering(array_merge($options, array('total' => true)), array($orderby => $orderdir), $limit, $offset);
        if($this->input->get('excel', true)){
            $users = $this->doctrine->em->getRepository('Entities\User')->findWithOrdering($options, array($orderby => $orderdir), null, null);
        }else{
            $users = $this->doctrine->em->getRepository('Entities\User')->findWithOrdering($options, array($orderby => $orderdir), $limit, $offset);
        }

		$rols = $this->doctrine->em->getRepository('Entities\Rol')->findAll();
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();

        $url_params = '?orderby='.$orderby.'&orderdir='.$orderdir;
        foreach($options as $name => $option)
            $url_params .= '&'.$name.'='.$option;

		$pagination_config['base_url'] = base_url().'backend/user/'.$url_params;
		$pagination_config['total_rows'] = $count;
		$pagination_config['per_page'] = $limit;

		$this->pagination->initialize($pagination_config);

		$this->loadData('users', $users);
		$this->loadData('rols', $rols);
        $this->loadData('servicios', $servicios);
        $this->loadData('offset', $offset);
        $this->loadData('orderby', $orderby);
        $this->loadData('orderdir', $orderdir);
        $this->loadData('rolid', $rol);
        $this->loadData('serviciocodigo', $servicio);
        $this->loadData('fullname', $fullname);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        if($this->input->get('excel', true)){
            $this->loadData('filename', 'usuarios');
            $this->loadBlock('content', 'backend/user/excel', $this->data);
            $this->renderView('backend/excel');
        }else{
            $this->loadBlock('content', 'backend/user/list', $this->data);
            $this->renderView('backend/layout');
        }

		
	}

	public function edit($userId){
		$this->load_user_form($this->doctrine->em->find('Entities\User', $userId), false);
	}

	public function add(){
		$this->sectionRols = array('mantencion');
		$this->checkUserAccess();
		$this->load_user_form(new Entities\User);
	}

	public function update(){
		$this->store_user($this->doctrine->em->find('Entities\User', $this->input->post('id', true)), false);
	}

	public function create(){
		$this->sectionRols = array('mantencion');
		$this->checkUserAccess();
		$this->store_user(new Entities\User);
	}

	function hashPassword($password){
		$salt = sha1(rand());
		$salted_password = sha1($password.$salt);
		return $salted_password.':'.$salt;
	}

	/*
	* Helper to strore the user on the database
	*/
	function store_user($user, $newUser = true){
		$password = $this->input->post('password', true);
		$servicio = $this->input->post('servicio', true);

		if($password){
			$user->setPassword($user->getHashedPassword($password));
		}

		//Si el usuario que está actualizando no tiene todos los permiso, actualizamos solo los campos posibles
		if($this->user->hasRol('mantencion')){
			$user->setEmail($this->input->post('email', true));	
			$user->setMinisterial($this->input->post('ministerial', true));
			$user->setInterministerial($this->input->post('interministerial', true));
			$user->setUpdatedAt(new DateTime());
			
			if($servicio != ''){
				$user->setServicio($this->doctrine->em->getRepository('Entities\Servicio')->findOneBy(array('codigo' => $servicio)));
			}
			
			$user->removeAllRols();
			if($this->input->post('rols', true)){
				foreach ($this->input->post('rols', true) as $key => $rol) {
					$user->addRol($this->doctrine->em->find('Entities\Rol', $rol));
				}
			}
		}

		$user->setFullName($this->input->post('fullname', true));


		if($newUser){
			if(!$password)
				$this->addMessage('Debe ingresar una clave.', 'error');
			if($this->doctrine->em->getRepository('Entities\User')->findOneBy(array('email' => $this->input->post('email', true))))
				$this->addMessage('El correo electrónico ya existe.', 'error');
			$user->setCreatedAt(new DateTime());
		}

		if($password != $this->input->post('password-confirm', true)){
			$this->addMessage('La clave y su confirmación no son iguales.', 'error');
		}

		if($this->error){
			$this->load_user_form($user, $newUser);
		}else{
			$this->addMessage('Usuario actualizado exitosamente.', 'success');
			$this->doctrine->em->persist($user);
			$this->doctrine->em->flush();
			if($this->user->hasRol('mantencion'))
				redirect('backend/user');
			else
				redirect('backend/user/edit/'.$user->getId());
		}

	}

	/*
	* Helper to load the user form view
	*/
	function load_user_form($user, $newUser = true){
		$this->loadData('formAction', $newUser?site_url('backend/user/create'):site_url('backend/user/update'));
		$this->loadData('userForm', $user);
		$this->loadData('rols', $this->doctrine->em->getRepository('Entities\Rol')->findAll());
		$this->loadData('servicios', $this->doctrine->em->getRepository('Entities\Servicio')->findAll());
        if($this->user->hasRol('mantencion')){
            $this->loadData('datasets', $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('idusuario' => $user->getId(), 'meaestros' => true)));
        }

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

		$this->loadBlock('content', 'backend/user/form', $this->data);

		$this->renderView('backend/layout');
	}

    public function generateApiToken($userId)
    {
        $usuario = $this->doctrine->em->find('Entities\User', $userId);
        $token = hash('ripemd160', $usuario->getEmail());
        $usuario->setApiToken($token);
        
        $this->doctrine->em->persist($usuario);
        $this->doctrine->em->flush();

        $callback = 'users.generateApiToken('.$userId.',"'.$token.'")';

        echo json_encode(array(
            'error' => false,
            'message' => 'Se ha generado el Token para la Api',
            'callback' => $callback
        ));

        return true;
    }
}