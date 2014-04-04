<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CIE_Controller {

    function __construct(){

        $this->sectionRols = array('publicacion||ingreso||mantencion');

        parent::__construct();

        $this->load->library('user_agent');

        $this->loadScript('page', site_url('assets/js/backend/reporte.js'));
    }

    public function index($datasetId = null)
    {   
        $this->load->library('pagination');

        $options = array();
        $dumy_reporte = new Entities\Reporte;

        $options['estado'] = $this->get_post('estado', null);
        $options['tipo_reporte_id'] = $this->get_post('tipo_reporte_id', null);
        $options['codigo_entidad'] = $this->get_post('codigo_entidad', null);
        $options['codigo_servicio'] = $this->get_post('codigo_servicio', null);
        $options['muestra_despublicados'] = $this->get_post('muestra_despublicados', null);
        $options['excel'] = $this->get_post('excel', null);

        $options['orderby'] = $this->get_post('orderby', 'r.id');
        $options['orderdir'] = $this->get_post('orderdir', 'desc');
        $options['limit'] = $this->get_post('limit', 10);
        $options['offset'] = $this->get_post('offset', 0);

        if($datasetId){ //En caso de listar los reportes de un dataset específico
            $dataset = $this->doctrine->em->find('Entities\Dataset', $datasetId);
            $dataset->checkUserAccess();

            $this->loadData('dataset', $dataset);

            if($dataset->getMaestro()){
                $this->loadData('active', 'reportes');
                $this->loadBlock('content-navbar', 'backend/dataset/navbar', $this->data);
            }

            $options['dataset_id'] = $dataset->getId();
            $options['muestra_despublicados'] = 1; //Siempre se muestran los reportes del dataset, aunque esté despublicado
        }

        $this->loadData('options', $options);
        $this->loadData('estados', $dumy_reporte->getTiposDeEstado());
        $this->loadData('tiposReporte', $this->doctrine->em->getRepository('Entities\TipoReporte')->findAll());
        $this->loadData('servicios', $this->doctrine->em->getRepository('Entities\Servicio')->findAll());

        $this->loadData('reportes', $this->doctrine->em->getRepository('Entities\Reporte')->findWithOptions($options));
        $options['total'] = true;
        $total = $this->doctrine->em->getRepository('Entities\Reporte')->findWithOptions($options);

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        /*Paginacion*/
        $pagination_base_url = array();
        foreach ($options as $key => $option) {
            if($option && $key != 'offset')
                $pagination_base_url[] = $key.'='.$option;
        }
        $pagination_config['base_url'] = current_url().'?'.implode('&',$pagination_base_url);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);
        $this->loadData('pagination', $this->pagination->create_links());

        if($options['excel']){
            $this->loadData('filename', 'reportes');
            $this->loadBlock('content', 'backend/reporte/excel', $this->data);
            $this->renderView('backend/excel');
        }else{
            $this->loadBlock('content', 'backend/reporte/list', $this->data);
            $this->renderView('backend/layout');   
        }

    }

    public function dataset($datasetId = null)
    {
        $this->index($datasetId);
    }
    
    public function view($reporteId = null)
    {
        $reporte = $this->doctrine->em->find('Entities\Reporte', $reporteId);
        $dataset = $reporte->getDataset();

        $this->loadData('dataset', $dataset);
        $this->loadData('reporte', $reporte);

        $this->loadData('active', 'reportes');
        $this->loadBlock('content-navbar', 'backend/dataset/navbar', $this->data);

        $this->loadBlock('content', 'backend/reporte/view', $this->data);

        $this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
        $this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));

        $this->renderView('backend/layout');
    }

    public function add($datasetId = null)
    {
        $reporte = new Entities\Reporte;
        $reporte->setDataset( $this->doctrine->em->find('Entities\Dataset', $datasetId) );
        $reporte->setEstado(2);
        if($this->get_post('campo_dataset', null)){
            $tipoReporte = $this->doctrine->em->getRepository('Entities\TipoReporte')->findOneBy(array('campo_dataset' => $this->get_post('campo_dataset', null)));
            if($tipoReporte)
                $reporte->setTipoReporte( $tipoReporte );
        }
        $this->load_reporte_form($reporte);
    }

    public function edit($reporteId = null)
    {
        $reporte = $this->doctrine->em->find('Entities\Reporte', $reporteId);
        $this->load_reporte_form($reporte, false);
    }

    public function create()
    {
        $reporte = new Entities\Reporte;
        $this->store_reporte($reporte);
    }

    public function update($reporteId = null)
    {
         $reporte = $this->doctrine->em->find('Entities\Reporte', $reporteId);
         $this->store_reporte($reporte, false);
    }

    public function delete($reporteId = null)
    {
        
        $reporte = $this->doctrine->em->find('Entities\Reporte', $reporteId);
        $this->doctrine->em->remove($reporte);
        $this->doctrine->em->flush();

        $referer = $this->agent->referrer();

        redirect($referer?$referer:'backend/reporte/');
    }

    public function revisar($reporteId = null)
    {
        $reporte = $this->doctrine->em->find('Entities\Reporte', $reporteId);
        $reporte->setEstado(3);
        $reporte->setUpdatedAt(new DateTime());
        $this->doctrine->em->persist($reporte);
        $this->doctrine->em->flush();
        redirect($this->agent->referrer());
    }

    public function store_reporte($reporte, $newReporte = true)
    {
        $dataset = $this->doctrine->em->find('Entities\Dataset', $this->input->get_post('dataset_id', true));
        $tipoReporte = $this->doctrine->em->find('Entities\TipoReporte', $this->input->get_post('tipo_reporte_id', true));
        $user = $this->doctrine->em->find('Entities\User', $this->input->get_post('user_id', true));

        if($newReporte)
            $reporte->setCreatedAt(new DateTime());

        $reporte->setDataset($dataset);
        $reporte->setTipoReporte($tipoReporte);
        $reporte->setUsuario($user);
        $reporte->setEstado( $this->input->get_post('estado', true) );
        $reporte->setOrigenPublico( $this->input->get_post('origen_publico', true) );
        $reporte->setComentarios( $this->input->get_post('comentarios', true) );
        $reporte->setNombre( $this->input->get_post('nombre', true) );
        $reporte->setEmail( $this->input->get_post('email', true) );
        $reporte->setUpdatedAt(new DateTime());

        $this->doctrine->em->persist($reporte);
        $this->doctrine->em->flush();

        $redirect_url = $this->input->get_post('referer', true)?$this->input->get_post('referer', true):('backend/reporte/dataset/'.$dataset->getId());

        redirect($redirect_url);
        
    }

    public function load_reporte_form($reporte, $newReporte = true)
    {
        $this->loadData('referer', $this->agent->referrer());

        $this->loadData('formAction', $newReporte?site_url('backend/reporte/create'):site_url('backend/reporte/update/'.$reporte->getId()));
        $this->loadData('reporte', $reporte);
        $this->loadData('dataset', $reporte->getDataset());
        $this->loadData('tiposReporte', $this->doctrine->em->getRepository('Entities\TipoReporte')->findAll());

        $this->loadBlock('content', 'backend/reporte/form', $this->data);

        $this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
        $this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));

        $this->renderView('backend/layout');
    }
    /*AJAX*/
    public function get_comentario_predefinido($tipo_reporte_id = null)
    {
        $tipoReporte = $this->doctrine->em->find('Entities\TipoReporte', $tipo_reporte_id);
        echo json_encode(array('comentarios' => $tipoReporte->getComentarioSugerido()));
    }
}