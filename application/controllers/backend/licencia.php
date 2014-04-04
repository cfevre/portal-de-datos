<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Licencia extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('cms');

		parent::__construct();
		$this->loadScript('page', site_url('assets/js/backend/licencia.js'));
	}
	
	public function index() {
    $licencias = $this->doctrine->em->getRepository('Entities\Licencia')->findAll();

		$this->loadData('licencias', $licencias);

		$this->setPageTitle('Licencias');

		$this->loadBlock('content', 'backend/licencia/list', $this->data);

		$this->renderView('backend/layout');
	}

	public function edit($licenciaId){
		$this->_load_licencia_form($this->doctrine->em->find('Entities\Licencia', $licenciaId), false);
	}

	public function add(){
		$this->_load_licencia_form(new Entities\Licencia);
	}

	public function create(){
		$this->_store_licencia(new Entities\Licencia);
	}

	public function update($licenciaId){
		$this->_store_licencia($this->doctrine->em->find('Entities\Licencia', $this->input->post('id')), false);
	}

	public function delete($licenciaId){
		$licencia = $this->doctrine->em->find('Entities\Licencia', $licenciaId);
		if($licencia->getDataset() && count($licencia->getDataset())){
			$this->addMessage('No se puede eliminar la licencia debido a que aún está asociada a uno o más datasets.');
		}else{
			$this->doctrine->em->remove($licencia);
			$this->doctrine->em->flush();
			$this->addMessage('La licencia ['.$licenciaId.'] ha sido eliminada.', 'success');
		}
		redirect('backend/licencia');
	}

	function _store_licencia($licencia, $newLicencia = true){
		$licencia->setNombre($this->input->post('nombre', true));
		$licencia->setUrl($this->input->post('url', true));

		if($newLicencia){
			$licencia->setCreatedAt(new DateTime());
		}

		$licencia->setUpdatedAt(new DateTime());

		$this->doctrine->em->persist($licencia);
		$this->doctrine->em->flush();

		$this->addMessage('Se ha '.($newLicencia?'grabado':'actualizado').' la licencia ['.$licencia->getId().']' , 'success');

		redirect('backend/licencia');
	}

	function _load_licencia_form($licencia, $newLicencia = true){
		$this->loadData('formAction', $newLicencia?site_url('backend/licencia/create'):site_url('backend/licencia/update'));
		$this->loadData('licencia', $licencia);

		$this->loadBlock('content', 'backend/licencia/form', $this->data);

		$this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
		$this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));

		$this->renderView('backend/layout');
	}
}