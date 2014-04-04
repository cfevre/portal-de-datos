<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entidades extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

  public function index() {
  	$this->enableCache();
  	$entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findWithDataset();
  	$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));
  	
  	$this->loadData('navItem', $navItem);
  	$this->loadData('entidades', $entidades);

  	$this->setPageTitle('Entidades');

  	$this->loadNavs();

  	$extra_crumbs[] = array('link' => site_url('entidades'), 'title' => 'Entidades');

  	$this->loadBreadcrumb($this->data, $extra_crumbs);

	$this->loadBlock('content', 'entidad/listar', $this->data);

  	$this->renderView('layout');
  }

  function ver ($codigoEntidad) {
  	$this->load->library('pagination');

  	$limit = 10;
  	$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
  	$orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
  	$orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

  	if($orderby == 'titulo')
	  		$orderdir = 'ASC';

  	$entidad = $this->doctrine->em->getRepository('Entities\Entidad')->findOneBy(array('codigo' => $codigoEntidad));
  	
  	if(!$entidad){
  		show_404('No se ha encontrado la entidad solicitada.');
  	}

  	$datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('entidad_codigo' => $entidad->getCodigo()), array($orderby => $orderdir), $limit, $offset);
  	$total = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('total' => true, 'entidad_codigo' => $entidad->getCodigo()), array($orderby => $orderdir), $limit, $offset);
  	$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));

		$pagination_config['base_url'] = site_url('entidades/ver/'.$codigoEntidad.'?orderby='.$orderby.'&orderdir='.$orderdir);
		$pagination_config['total_rows'] = $total;
		$pagination_config['per_page'] = $limit;

		$this->pagination->initialize($pagination_config);
  	
  	$this->loadData('entidad', $entidad);
  	$this->loadData('navItem', $navItem);
  	$this->loadData('datasets', $datasets);
  	$this->loadData('orderby', $orderby);
  	$this->loadData('offset', $offset);
  	$this->loadData('limit', $limit);
  	$this->loadData('total', $total);
  	$this->loadData('pagination', $this->pagination->create_links());
  	$this->loadData('list_title', $entidad->getNombre());

  	$this->setPageTitle($entidad->getNombre());

  	$this->loadNavs();

  	$extra_crumbs[] = array('link' => '', 'title' => 'Entidades');
  	$extra_crumbs[] = array('link' => '', 'title' => $entidad->getNombre());

  	$this->loadBreadcrumb($this->data, $extra_crumbs);

		$this->loadBlock('content', 'dataset/listar', $this->data);

  	$this->renderView('layout');
  }

    public function rss()
    {
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->getEntidadesConTotales();
        $this->loadData('entidades', $entidades);
        header("Content-Type: application/xml; charset=UTF-8");
        $this->load->view('entidad/rss', $this->data);
    }
}
