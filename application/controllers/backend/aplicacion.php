<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aplicacion extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('cms');

		parent::__construct();
		$this->loadScript('page', site_url('assets/js/backend/aplicacion.js'));
	}
	
	public function index() {
  	$this->load->library('pagination');

  	$limit = 10;
  	$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
  	$orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
  	$orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

    $total = $this->doctrine->em->getRepository('Entities\Aplicacion')->findWithOrdering(array('total' => true, 'all' => true), array($orderby => $orderdir), $limit, $offset);
    $aplicaciones = $this->doctrine->em->getRepository('Entities\Aplicacion')->findWithOrdering(array('all' => true), array($orderby => $orderdir), $limit, $offset);

		$pagination_config['base_url'] = site_url('backend/participacion/?orderby='.$orderby.'&orderdir='.$orderdir);
		$pagination_config['total_rows'] = $total;
		$pagination_config['per_page'] = $limit;

		$this->pagination->initialize($pagination_config);
  	
  	$this->loadData('orderby', $orderby);
  	$this->loadData('orderdir', $orderdir);
  	$this->loadData('offset', $offset);
  	$this->loadData('limit', $limit);
  	$this->loadData('total', $total);
  	$this->loadData('pagination', $this->pagination->create_links());

		$this->loadData('aplicaciones', $aplicaciones);

		$this->setPageTitle('Aplicaciones');

		$this->loadBlock('content', 'backend/aplicacion/list', $this->data);

		$this->renderView('backend/layout');
	}

	public function edit($aplicacionId){
		$this->_load_aplicacion_form($this->doctrine->em->find('Entities\Aplicacion', $aplicacionId), false);
	}

	public function add(){
		$this->_load_aplicacion_form(new Entities\Aplicacion);
	}

	public function create(){
		$this->_store_aplicacion(new Entities\Aplicacion);
	}

	public function update($aplicacionId){
		$this->_store_aplicacion($this->doctrine->em->find('Entities\Aplicacion', $this->input->post('id')), false);
	}

	function _store_aplicacion($aplicacion, $newAplicacion = true){
		$aplicacion->setNombre($this->input->post('nombre', true));
		$aplicacion->setAutor($this->input->post('autor', true));
		$aplicacion->setUrl($this->input->post('url', true));
		$aplicacion->setAcceso($this->input->post('acceso', true));
		$aplicacion->setPlataforma($this->input->post('plataforma', true));
		$aplicacion->setDescripcion($this->input->post('descripcion'));

		if($newAplicacion){
			$aplicacion->setPublicado(false);
			$aplicacion->setCreatedAt(new DateTime());
		}

		$aplicacion->setUpdatedAt(new DateTime());

		$this->doctrine->em->persist($aplicacion);
		$this->doctrine->em->flush();

		$this->addMessage('Se ha '.($newAplicacion?'grabado':'actualizado').' la aplicacion ['.$aplicacion->getId().']' , 'success');

		redirect('backend/aplicacion');
	}

	function _load_aplicacion_form($aplicacion, $newAplicacion = true){
		$this->loadData('formAction', $newAplicacion?site_url('backend/aplicacion/create'):site_url('backend/aplicacion/update'));
		$this->loadData('aplicacion', $aplicacion);

		$this->loadBlock('content', 'backend/aplicacion/form', $this->data);

		$this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
		$this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));

		$this->renderView('backend/layout');
	}

	/*Ajax Calls*/
	public function togglePublicado($aplicacionId = null){
		if(!$this->isAjax())
			return false;
		if(!$aplicacionId)
			$aplicacionId = $this->input->get('id', true);

		$aplicacion = $this->doctrine->em->find('Entities\Aplicacion', $aplicacionId);

		$aplicacion->setPublicado(!$aplicacion->getPublicado());
		$aplicacion->setUpdatedAt(new DateTime());

		if($aplicacion->getPublicado())
			$aplicacion->setPublicadoAt(new DateTime());

		$this->doctrine->em->persist($aplicacion);
		$this->doctrine->em->flush();

		$callback = 'aplicacion.updatePublicadoButton('.$aplicacionId.','.($aplicacion->getPublicado()?'true':'false').')';

		echo json_encode(array(
			'error' => false,
			'message' => 'Estado de publicación actualizado',
			'callback' => $callback
		));

		return true;
	}
}