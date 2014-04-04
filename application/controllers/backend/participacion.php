<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participacion extends CIE_Controller {

    function __construct(){

        $this->sectionRols = array('mantencion');

        parent::__construct();
        $this->loadScript('page', site_url('assets/js/backend/participacion.js'));
    }
    
    public function index() {
        $this->load->library('pagination');

        $options['limit'] = 10;
        $options['offset'] = $this->get_post('offset', 0);
        $options['orderby'] = $this->get_post('orderby', 'created_at');
        $options['orderdir'] = $this->get_post('orderdir', 'DESC');
        $options['excel'] = $this->get_post('excel', null);
        $options['all'] = true;

        $participaciones = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);
        $options['total'] = true;
        $total = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);

        $pagination_config['base_url'] = site_url('backend/participacion/?orderby='.$options['orderby'].'&orderdir='.$options['orderdir']);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);
      
        $this->loadData('orderby', $options['orderby']);
        $this->loadData('orderdir', $options['orderdir']);
        $this->loadData('offset', $options['offset']);
        $this->loadData('limit', $options['limit']);
        $this->loadData('total', $total);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadData('participaciones', $participaciones);

        $this->setPageTitle('Participaciones');

        if($options['excel']){
            $this->loadData('filename', 'participaciones');
            $this->loadBlock('content', 'backend/participacion/excel', $this->data);
            $this->renderView('backend/excel');
        }else{
            $this->loadBlock('content', 'backend/participacion/list', $this->data);
            $this->renderView('backend/layout');
        }

    }

    public function view($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $this->loadData('participacion', $participacion);

        $this->loadBlock('content', 'backend/participacion/view', $this->data);
        $this->renderView('backend/layout');
    }

    /*Ajax Calls*/
    public function togglePublicado($participacionId = null){
        if(!$this->isAjax())
            return false;
        if(!$participacionId)
            $participacionId = $this->input->get('id', true);

        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $participacion->setPublicado(!$participacion->getPublicado());
        $this->doctrine->em->persist($participacion);
        $this->doctrine->em->flush();

        $callback = 'participacion.updatePublicadoButton('.$participacionId.','.($participacion->getPublicado()?'true':'false').')';

        echo json_encode(array(
            'error' => false,
            'message' => 'Estado de publicación actualizado',
            'callback' => $callback
        ));

        return true;
    }
}