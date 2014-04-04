<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CIE_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function index() {
		$this->loadNavs();
		$this->loadBlock('content', 'auth/login_form');
		$this->setPageTitle('Login');
		$this->renderView('layout');

	}

	public function login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		if(!$email)
			$this->addMessage('Debe ingresar su E-Mail');
		if(!$password)
			$this->addMessage('Debe ingresar si clave');

		if($this->error){
			redirect('/auth');
		}

		$user = $this->doctrine->em->getRepository('Entities\User')->findOneBy(array('email' => $email));

		if(!$user){

			$this->addMessage('Usuario o clave incorrecta.');

			redirect('/auth');

		}

		$entitySerializer = new \Doctrine\EntitySerializer($this->doctrine->em);
		$user = $entitySerializer->toArray($user);

		if( $this->authenticate($user, $password) ){

			unset($user['password']);

			$this->session->set_userdata('user', $user);

			redirect(site_url('backend'));

		}else{

			$this->addMessage('Usuario o clave incorrecta.');

			redirect('/auth');

		}

	}

	public function authenticate($user, $password){
		$validUser = false;

		if(!is_null($user)){
			$pass_data = explode(':', $user['password']);
			$validUser = ($pass_data[0] === sha1($password.$pass_data[1]));
		}

		return $validUser;
	}

	public function performpasswordreset(){
		$this->config->load('recaptcha');
		$this->load->helper('recaptcha');

		$password = $this->input->post('password', true);
		$passwordconfirm = $this->input->post('passwordconfirm', true);
		$reset_code = $this->input->post('reset_code', true);

		$user = $this->doctrine->em->getRepository('Entities\User')->findOneBy(array('reset_code' => $reset_code));

		if(!$user){
			$this->addMessage('Su código de verificación parece ser invalido, realice el proceso de recuperación de clave nuevamente.');
			redirect('/auth/recoverpassword');
		}

		if(new DateTime() > $user->getResetExpiration()){
			$this->addMessage('Su código de verificación ha expirado, realice el proceso de recuperación de clave nuevamente.');
			redirect('/auth/recoverpassword');
		}

		$resp = recaptcha_check_answer($this->config->item('recaptcha_prikey'), $this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $this->input->post('recaptcha_response_field'));

		if (!$resp->is_valid)
			$this->addMessage('Captcha inválido.');

		if(!$password)
			$this->addMessage('Debe ingresar su nueva clave.');
		
		if($password != $passwordconfirm)
			$this->addMessage('Las claves no coinciden.');

		if(!$this->error){

			$user->setResetExpiration(new DateTime());
			$user->setPassword($user->getHashedPassword($password));
			
			$this->doctrine->em->persist($user);
			$this->doctrine->em->flush();

			$this->addMessage('Su clave ha sido actualizada exitosamente. Ahora puede ingresar con sus nuevas credenciales.', 'success');
			redirect('/auth');

		}else{
			redirect('/auth/resetpassword/'.$reset_code);
		}
	}

	public function resetpassword($reset_code){
		$user = $this->doctrine->em->getRepository('Entities\User')->findOneBy(array('reset_code' => $reset_code));
		
		if(!$user){
			$this->addMessage('Su código de verificación parece ser invalido, realice el proceso de recuperación de clave nuevamente.');
			redirect('/auth/recoverpassword');
		}

		if(new DateTime() > $user->getResetExpiration()){
			$this->addMessage('Su código de verificación ha expirado, realice el proceso de recuperación de clave nuevamente.');
			redirect('/auth/recoverpassword');
		}

		$this->loadNavs();
		$this->loadData('reset_code', $reset_code);
		$this->loadBlock('content', 'auth/resetpassword');
		$this->setPageTitle('Recurperar Clave');
		$this->renderView('layout');
	}

	public function recoverpassword(){
		$this->loadNavs();
		$this->loadBlock('content', 'auth/recoverpassword');
		$this->setPageTitle('Recurperar Clave');
		$this->renderView('layout');
	}

	public function sendpassword($value=''){
		$this->load->library('email');
	  $email = $this->input->post('email');
	  $user = $this->doctrine->em->getRepository('Entities\User')->findOneBy(array('email' => $email));

	  if(!$user){
	  	$this->addMessage('No hemos podido encontrar el correo ingresado, verifique que esté correcto e inténtelo nuevamente.');
	  	redirect('/auth/recoverpassword');
	  }

		/*Se crea un nuevo codigo para efectuar el reseteo del password*/
		$reset_code = sha1($user->getEmail().':'.mktime());
		$reset_expiration = new DateTime();
		$reset_expiration->setTimestamp(mktime()+1800);//Se dan 30 minutos para cambiar la clave antes
		$user->setResetCode($reset_code);
		$user->setResetExpiration($reset_expiration);

		$this->doctrine->em->persist($user);
		$this->doctrine->em->flush();

	  $this->email->from('datos@datos.gob.cl');
	  $this->email->to($email);
	  $this->email->subject('Reestablecimiento de clave');
	  $this->email->message('Estimado(a) '.$user->getFullname().' se ha hecho una solicitud de recuperación de clave, para confirmar su identidad haga click en el enlace que se indica a continuación y le enviaremos su clave. Si ud. no ha hecho esta solicitud ignore o elimine este mensaje.<br />'.site_url('auth/resetpassword/'.$reset_code));
	  $this->email->send();

	  $this->addMessage('Se ha enviado un mensaje a la dirección de correo electrónico indicada con instrucciones para restaurar su clave.', 'success');
	  redirect('auth');
	}

	public function logout(){
		$this->session->unset_userdata('user');

		redirect('auth');
	}
}
