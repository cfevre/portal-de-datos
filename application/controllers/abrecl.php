<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AbreCL extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

  public function index() {
  	redirect('http://abrecl.datos.gob.cl');
  }

}
