<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

  public function index() {
  	redirect(site_url('entidades'));
  }

  function ver ($codigoServicio) {
  	$this->load->library('pagination');

  	$limit = 10;
  	$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
  	$orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
  	$orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

  	if($orderby == 'titulo')
	  		$orderdir = 'ASC';

  	$servicio = $this->doctrine->em->getRepository('Entities\Servicio')->findOneBy(array('codigo' => $codigoServicio));
  	
  	if(!$servicio){
  		show_404('No se ha encontrado el servicio solicitada.');
  	}

  	$datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('servicio_codigo' => $servicio->getCodigo()), array($orderby => $orderdir), $limit, $offset);
  	$total = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('total' => true, 'servicio_codigo' => $servicio->getCodigo()), array($orderby => $orderdir), $limit, $offset);
  	$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));

		$pagination_config['base_url'] = base_url().'servicios/ver/'.$codigoServicio.'?orderby='.$orderby.'&orderdir='.$orderdir;
		$pagination_config['total_rows'] = $total;
		$pagination_config['per_page'] = $limit;

		$this->pagination->initialize($pagination_config);
  	
  	$this->loadData('servicio', $servicio);
  	$this->loadData('navItem', $navItem);
  	$this->loadData('datasets', $datasets);
  	$this->loadData('orderby', $orderby);
  	$this->loadData('offset', $offset);
  	$this->loadData('limit', $limit);
  	$this->loadData('total', $total);
  	$this->loadData('pagination', $this->pagination->create_links());
  	$this->loadData('list_title', $servicio->getNombre());

  	$this->setPageTitle($servicio->getNombre());

  	$this->loadNavs();

  	$extra_crumbs[] = array('link' => site_url('entidades'), 'title' => 'Entidades');
  	$extra_crumbs[] = array('link' => site_url('entidades/ver/'.$servicio->getEntidad()->getCodigo()), 'title' => $servicio->getEntidad()->getNombre());
  	$extra_crumbs[] = array('link' => '', 'title' => $servicio->getNombre());

  	$this->loadBreadcrumb($this->data, $extra_crumbs);

		$this->loadBlock('content', 'dataset/listar', $this->data);

  	$this->renderView('layout');
  }
}
