<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticia extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('cms');

		parent::__construct();
		$this->loadScript('page', site_url('assets/js/backend/noticia.js'));
	}
	
	public function index() {
  	$this->load->library('pagination');

  	$limit = 10;
  	$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
  	$orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
  	$orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

    $total = $this->doctrine->em->getRepository('Entities\Noticia')->findWithOrdering(array('total' => true, 'all' => true), array($orderby => $orderdir), $limit, $offset);
    $noticias = $this->doctrine->em->getRepository('Entities\Noticia')->findWithOrdering(array('all' => true), array($orderby => $orderdir), $limit, $offset);

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

		$this->loadData('noticias', $noticias);

		$this->setPageTitle('Noticias');

		$this->loadBlock('content', 'backend/noticia/list', $this->data);

		$this->renderView('backend/layout');
	}

	public function edit($noticiaId){
		$this->_load_noticia_form($this->doctrine->em->find('Entities\Noticia', $noticiaId), false);
	}

	public function add(){
		$this->_load_noticia_form(new Entities\Noticia);
	}

	public function create(){
		$this->_store_noticia(new Entities\Noticia);
	}

	public function update($noticiaId){
		$this->_store_noticia($this->doctrine->em->find('Entities\Noticia', $this->input->post('id')), false);
	}

	function _store_noticia($noticia, $newNoticia = true){
		$noticia->setTitulo($this->input->post('titulo', true));
		$noticia->setResumen($this->input->post('resumen'));
		$noticia->setContenido($this->input->post('contenido'));
		$noticia->setFoto($this->input->post('foto'), true);
		if($newNoticia){
			$noticia->setPublicado(false);
			$noticia->setCreatedAt(new DateTime());
		}

		$noticia->setUpdatedAt(new DateTime());

		$this->doctrine->em->persist($noticia);
		$this->doctrine->em->flush();

		$this->addMessage('Se ha '.($newNoticia?'grabado':'actualizado').' la noticia ['.$noticia->getId().']' , 'success');

		redirect('backend/noticia');
	}

	function _load_noticia_form($noticia, $newNoticia = true){
		$this->loadData('formAction', $newNoticia?site_url('backend/noticia/create'):site_url('backend/noticia/update'));
		$this->loadData('noticia', $noticia);

		$this->loadBlock('content', 'backend/noticia/form', $this->data);

		$this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
		$this->loadScript('fineuploader', site_url('assets/js/fineuploader/jquery.fineuploader-3.0.min.js'));
		$this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));
		$this->loadStylesheet('fineuploader', site_url('assets/js/fineuploader/fineuploader.css'));

		$this->renderView('backend/layout');
	}

	/*Ajax Calls*/
	public function togglePublicado($noticiaId = null){
		if(!$this->isAjax())
			return false;
		if(!$noticiaId)
			$noticiaId = $this->input->get('id', true);

		$noticia = $this->doctrine->em->find('Entities\Noticia', $noticiaId);

		$noticia->setPublicado(!$noticia->getPublicado());
		$noticia->setUpdatedAt(new DateTime());

		if($noticia->getPublicado())
			$noticia->setPublicadoAt(new DateTime());

		$this->doctrine->em->persist($noticia);
		$this->doctrine->em->flush();

		$callback = 'noticia.updatePublicadoButton('.$noticiaId.','.($noticia->getPublicado()?'true':'false').')';

		echo json_encode(array(
			'error' => false,
			'message' => 'Estado de publicación actualizado',
			'callback' => $callback
		));

		return true;
	}
}