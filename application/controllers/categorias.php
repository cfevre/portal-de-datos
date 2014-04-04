<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

    public function index()
    {
        $this->enableCache();        

        $this->setPageTitle('Categorías');
        
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria')->getCategoriasConTotales();
        $this->loadData('categorias', $categorias);

        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));
        $this->loadData('navItem', $navItem);
        $this->loadNavs();

        $extra_crumbs[] = array('link' => '', 'title' => 'Categorías');
        $this->loadBreadcrumb($this->data, $extra_crumbs);
        $this->loadBlock('content', 'categoria/listar', $this->data);

        $this->loadScript('masonry', site_url('assets/js/libs/jquery.masonry.min.js'));

        $this->renderView('layout');
    }
 
  function ver ($idCategoria) {
  	$this->load->library('pagination');

  	$limit = 10;
  	$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
  	$orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
  	$orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

  	if($orderby == 'titulo')
	  		$orderdir = 'ASC';

  	$categoria = $this->doctrine->em->getRepository('Entities\Categoria')->findOneBy(array('id' => $idCategoria));
  	
  	if(!$categoria){
  		show_404('No se ha encontrado la categoría solicitada.');
  	}

  	$datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('idcategoria' => $categoria->getId()), array($orderby => $orderdir), $limit, $offset);
  	$total = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('total' => true, 'idcategoria' => $categoria->getId()), array($orderby => $orderdir), $limit, $offset);
  	$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));

	$pagination_config['base_url'] = base_url().'categorias/ver/'.$idCategoria.'?orderby='.$orderby.'&orderdir='.$orderdir;
	$pagination_config['total_rows'] = $total;
	$pagination_config['per_page'] = $limit;

	$this->pagination->initialize($pagination_config);
  	
  	$this->loadData('categoria', $categoria);
  	$this->loadData('navItem', $navItem);
  	$this->loadData('datasets', $datasets);
  	$this->loadData('orderby', $orderby);
  	$this->loadData('offset', $offset);
  	$this->loadData('limit', $limit);
  	$this->loadData('total', $total);
  	$this->loadData('pagination', $this->pagination->create_links());
  	$this->loadData('list_title', 'Categoría: '.$categoria->getNombre());

  	$this->setPageTitle('Categoría: '.$categoria->getNombre());

  	$this->loadNavs();

  	$extra_crumbs[] = array('link' => site_url('categorias'), 'title' => 'Categorías');
  	$extra_crumbs[] = array('link' => '', 'title' => $categoria->getNombre());

  	$this->loadBreadcrumb($this->data, $extra_crumbs);

		$this->loadBlock('content', 'dataset/listar', $this->data);

  	$this->renderView('layout');
  }
    public function rss($options = 'totales')
    {
        if($options == 'totales'){
            $categorias = $this->doctrine->em->getRepository('Entities\Categoria')->getCategoriasConTotales();
        }
        if($options == 'descargas'){
            $datasets = array();
            //Se obtienen todas las categorias
            $categorias = $this->doctrine->em->getRepository('Entities\Categoria')->findAll();
            foreach ($categorias as $categoria) {
                $datasets[$categoria->getId()] = $this->doctrine->em->getRepository('Entities\Categoria')->getDatasetMasDescargados($categoria->getId(), 5);
            }
            $this->loadData('datasets', $datasets);
        }
        
        $this->loadData('categorias', $categorias);
        header("Content-Type: application/xml; charset=UTF-8");
        $this->load->view('categoria/rss', $this->data);
    }
}
