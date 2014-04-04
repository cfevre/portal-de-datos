<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends CIE_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function index() {
		$this->setPageTitle('Backend Datos.gob.cl');

		$this->loadBlock('content', 'backend/backend/index', $this->data);

		$this->renderView('backend/layout');
	}

	public function get_servicios_entidad($codigo_entidad = ''){
		$a_servicios = array();
		$servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findBy(array('entidad_codigo' => $codigo_entidad));
		$entitySerializer = new \Doctrine\EntitySerializer($this->doctrine->em);
		foreach ($servicios as $key => $servicio) {
			$a_servicios[] = $entitySerializer->toArray($servicio);
		}
		echo json_encode($a_servicios);
	}

	public function get_sectores(){
		$a_sectores = array();
		$sectores = $this->doctrine->em->getRepository('Entities\Sector')->findAll();
		foreach ($sectores as $key => $sector) {
			$a_sectores[] = $sector->getNombre().' ('.$sector->getTipo().')';
		}
		echo json_encode($a_sectores);
	}

	public function get_tags(){
		$a_tags = array();
		$tags = $this->doctrine->em->getRepository('Entities\Tag')->findAll();
		foreach ($tags as $key => $tag) {
			$a_tags[] = $tag->getNombre();
		}
		echo json_encode($a_tags);
	}

}