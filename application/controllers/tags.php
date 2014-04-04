<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

  public function index() {

  	//$tags = $this->doctrine->em->getRepository('Entities\Tag')->findAll();
  	$this->enableCache();
		$tags = $this->doctrine->em->getRepository('Entities\Tag')->findPopulares();
  	$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));
  	
  	$this->loadData('navItem', $navItem);
  	$this->loadData('tags', $tags);

  	$this->setPageTitle('Tags');

  	$this->loadNavs();

  	$extra_crumbs[] = array('link' => '', 'title' => 'Listado de Etiquetas');

  	$this->loadBreadcrumb($this->data, $extra_crumbs);

		$this->loadBlock('content', 'tag/listar', $this->data);

  	$this->renderView('layout');
  }

  function ver ($idTag) {
  	$this->load->library('pagination');

  	$limit = 10;
  	$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
  	$orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
  	$orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

  	if($orderby == 'titulo')
	  		$orderdir = 'ASC';

  	$tag = $this->doctrine->em->getRepository('Entities\Tag')->findOneBy(array('id' => $idTag));
  	
  	if(!$tag){
  		show_404('No se ha encontrado el tag solicitado.');
  	}

  	$datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('idtag' => $tag->getId()), array($orderby => $orderdir), $limit, $offset);
  	$total = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('total' => true, 'idtag' => $tag->getId()), array($orderby => $orderdir), $limit, $offset);
  	$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));

		$pagination_config['base_url'] = base_url().'tags/ver/'.$idTag.'?orderby='.$orderby.'&orderdir='.$orderdir;
		$pagination_config['total_rows'] = $total;
		$pagination_config['per_page'] = $limit;

		$this->pagination->initialize($pagination_config);
  	
  	$this->loadData('tag', $tag);
  	$this->loadData('navItem', $navItem);
  	$this->loadData('datasets', $datasets);
  	$this->loadData('orderby', $orderby);
  	$this->loadData('offset', $offset);
  	$this->loadData('limit', $limit);
  	$this->loadData('total', $total);
  	$this->loadData('pagination', $this->pagination->create_links());
  	$this->loadData('list_title', 'Tag: '.$tag->getNombre());

  	$this->setPageTitle('Tag: '.$tag->getNombre());

  	$this->loadNavs();

  	$extra_crumbs[] = array('link' => site_url('tags'), 'title' => 'Tags');
  	$extra_crumbs[] = array('link' => '', 'title' => $tag->getNombre());

  	$this->loadBreadcrumb($this->data, $extra_crumbs);

		$this->loadBlock('content', 'dataset/listar', $this->data);

  	$this->renderView('layout');
  }
}
