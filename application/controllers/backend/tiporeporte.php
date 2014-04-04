<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TipoReporte extends CIE_Controller {

    function __construct(){

        $this->sectionRols = array('cms');

        parent::__construct();
        $this->loadScript('page', site_url('assets/js/backend/reporte.js'));
    }
    
    public function index() {
        $tiposReporte = $this->doctrine->em->getRepository('Entities\TipoReporte')->findAll();

        $this->loadData('tiposReporte', $tiposReporte);

        $this->setPageTitle('Tipos de Reporte');

        $this->loadBlock('content', 'backend/tiporeporte/list', $this->data);

        $this->renderView('backend/layout');
    }

    public function edit($tipoReporteId){
        $this->_load_tipo_reporte_form($this->doctrine->em->find('Entities\TipoReporte', $tipoReporteId), false);
    }

    public function add(){
        $this->_load_tipo_reporte_form(new Entities\TipoReporte);
    }

    public function create(){
        $this->_store_tipo_reporte(new Entities\TipoReporte);
    }

    public function update($tipoReporteId){
        $this->_store_tipo_reporte($this->doctrine->em->find('Entities\TipoReporte', $this->input->post('id')), false);
    }

    public function delete($tipoReporteId){
        $tipoReporte = $this->doctrine->em->find('Entities\TipoReporte', $tipoReporteId);
        $tituloTipoReporte = $tipoReporte->getTitulo();
        if($tipoReporte->getReportes() && count($tipoReporte->getReportes())){
            $this->addMessage('No se puede eliminar el tipo de reporte debido a que aún está asociada a uno o más reportes.');
        }else{
            $this->doctrine->em->remove($tipoReporte);
            $this->doctrine->em->flush();
            $this->addMessage('El tipo de reporte ['.$tituloTipoReporte.'] ha sido eliminada.', 'success');
        }
        redirect('backend/tiporeporte');
    }

    function _store_tipo_reporte($tipoReporte, $newTipoReporte = true){
        $gradoReporte = $this->doctrine->em->find('Entities\GradoReporte', $this->input->post('grado_reporte_id', true));

        $tipoReporte->setTitulo($this->input->post('titulo', true));
        $tipoReporte->setComentarioSugerido($this->input->post('comentario_sugerido', true));
        $tipoReporte->setPublico($this->input->post('publico', true));
        $tipoReporte->setCampoDataset($this->input->post('campo_dataset', true));
        $tipoReporte->setGradoReporte($gradoReporte);

        $this->doctrine->em->persist($tipoReporte);
        $this->doctrine->em->flush();

        $this->addMessage('Se ha '.($newTipoReporte?'grabado':'actualizado').' el tipo de reporte ['.$tipoReporte->getId().']' , 'success');

        redirect('backend/tiporeporte');
    }

    function _load_tipo_reporte_form($tipoReporte, $newTipoReporte = true){
        $this->loadData('formAction', $newTipoReporte?site_url('backend/tiporeporte/create'):site_url('backend/tiporeporte/update'));
        $this->loadData('tipoReporte', $tipoReporte);
        $this->loadData('camposDataset', $this->doctrine->em->getRepository('Entities\Dataset')->getCampoDataset());
        $this->loadData('gradosReporte', $this->doctrine->em->getRepository('Entities\GradoReporte')->findAll());

        $this->loadBlock('content', 'backend/tiporeporte/form', $this->data);

        $this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
        $this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));

        $this->renderView('backend/layout');
    }
}