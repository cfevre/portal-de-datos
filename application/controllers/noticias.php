<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
  	$this->load->library('pagination');

  	$limit = 4;
  	$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
  	$orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
  	if($orderby == 'titulo'){
  		$orderdir = 'ASC';
  	}else{
  		$orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';
  	}

    $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'noticias'));

    $total = $this->doctrine->em->getRepository('Entities\Noticia')->findWithOrdering(array('total' => true), array($orderby => $orderdir), $limit, $offset);
    $noticias = $this->doctrine->em->getRepository('Entities\Noticia')->findWithOrdering(null, array($orderby => $orderdir), $limit, $offset);

		$pagination_config['base_url'] = site_url('noticias?orderby='.$orderby.'&orderdir='.$orderdir);
		$pagination_config['total_rows'] = $total;
		$pagination_config['per_page'] = $limit;

		$this->pagination->initialize($pagination_config);
  	
  	$this->loadData('orderby', $orderby);
  	$this->loadData('offset', $offset);
  	$this->loadData('limit', $limit);
  	$this->loadData('total', $total);
  	$this->loadData('pagination', $this->pagination->create_links());

		$this->loadData('navItem', $navItem);
		$this->loadData('noticias', $noticias);

		$this->setPageTitle('Noticias');

		$this->loadNavs();
		$this->loadBreadcrumb($this->data);
		$this->loadBlock('content', 'noticia/listar', $this->data);

		$this->renderView('layout');
	}

	public function ver($noticiaId = 0){
		$this->enableCache();
		$navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('alias'=>'noticias'));
		$noticia = $this->doctrine->em->getRepository('Entities\Noticia')->find($noticiaId);

		if(!$noticia)
			show_404('La noticia no ha sido encontrada.');
		
		$this->loadData('navItem', $navItem);
		$this->loadData('noticia', $noticia);

		$extra_crumbs[] = array('link' => '', 'title' => $noticia->getTitulo());

		$this->setPageTitle($noticia->getTitulo());

		$this->loadNavs();
		$this->loadBreadcrumb($this->data, $extra_crumbs);
		$this->loadBlock('content', 'noticia/ver', $this->data);

		$this->renderView('layout');
	}

  public function rss($limit = 4) {
    $noticias = $this->doctrine->em->getRepository('Entities\Noticia')->findWithOrdering(null, array('created_at' => 'DESC'), $limit);
    $this->loadData('noticias', $noticias);

    header("Content-Type: application/xml; charset=UTF-8");
  	$this->load->view('noticia/rss', $this->data);
  }

}
