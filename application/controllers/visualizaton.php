<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visualizaton extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

  public function index() {
  	redirect('http://visualizaton.datos.gob.cl');
  }

}
