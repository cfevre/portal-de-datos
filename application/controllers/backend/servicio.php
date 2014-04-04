<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicio extends CIE_Controller {

    function __construct(){

        $this->sectionRols = array('mantencion');

        parent::__construct();

        $this->loadScript('page', site_url('assets/js/backend/servicio.js'));
    }

    public function index(){
        $this->load->library('pagination');

        $options['order_by'] = $this->get_post('orderby', 'd.id');
        $options['order_dir'] = $this->get_post('orderdir', 'desc');
        $options['offset'] = $this->get_post('offset', 0);
        $options['limit'] = 20;

        $options['nombre_servicio'] = $this->get_post('nombre_servicio', '');
        $options['entidad_codigo'] = $this->get_post('entidad_codigo', '');
        $options['con_recurso'] = $this->get_post('con_recurso', '');

        $count = $this->doctrine->em->getRepository('Entities\Servicio')->findWithOptions(array_merge($options, array('total' => true)));
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findWithOptions($options);
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findAll();

        $pagination_config['base_url'] = base_url()
            .'backend/servicio/?orderby='.$options['order_by']
            .'&orderdir='.$options['order_dir']
            .'&nombre_servicio='.$options['nombre_servicio']
            .'&con_recurso='.$options['con_recurso'];

        $pagination_config['total_rows'] = $count;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);

        $this->loadData('servicios', $servicios);
        $this->loadData('entidades', $entidades);
        $this->loadData('offset', $options['offset']);
        $this->loadData('orderby', $options['order_by']);
        $this->loadData('orderdir', $options['order_dir']);
        $this->loadData('nombre_servicio', $options['nombre_servicio']);
        $this->loadData('entidad_codigo', $options['entidad_codigo']);
        $this->loadData('con_recurso', $options['con_recurso']);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadBlock('content', 'backend/servicio/list', $this->data);
        $this->renderView('backend/layout');
    }

    public function view($codigo = null){
        $this->load->library('pagination');

        $options['order_by'] = $this->get_post('orderby', 'd.id');
        $options['order_dir'] = $this->get_post('orderdir', 'desc');
        $options['offset'] = $this->get_post('offset', 0);
        $options['limit'] = 10;
        $options['codigo_servicio'] = $codigo;

        $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($codigo);

        $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetEntidadServicio($options);
        $total_datasets = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetEntidadServicio(array_merge($options, array('total' => true)));

        $pagination_config['base_url'] = base_url()
            .'backend/servicio/view/'.$codigo.'?orderby='.$options['order_by']
            .'&orderdir='.$options['order_dir'];

        $pagination_config['total_rows'] = $total_datasets;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);

        $this->loadData('servicio', $servicio);
        $this->loadData('datasets', $datasets);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        $this->loadBlock('content', 'backend/servicio/view', $this->data);
        $this->renderView('backend/layout');
    }

    public function edit($codigo = null){
        $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($codigo);
        $this->load_servicio_form($servicio, false);
    }

    public function add(){
        $this->load_servicio_form(new \Entities\Servicio, true);
    }
    
    public function update($codigo = null){
        $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($codigo);
        $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->actualizaServicio($servicio, $this->input->post());

        $this->addMessage('Se ha actualizado el servicio.' , 'success');
        redirect('backend/servicio/edit/'.$servicio->getCodigo());
    }

    public function create()
    {
        $rServicio = $this->doctrine->em->getRepository('Entities\Servicio');
        $servicio = $rServicio->creaServicio($this->input->post());

        if($rServicio->getErrors()){
            $errors = $rServicio->getErrors();

            foreach ($errors as $error) {
                $this->addMessage($error);
            }

            $this->load_servicio_form($servicio, true);
        }else{
            $this->addMessage('Se ha creado el nuevo servicio '.$servicio->getNombre, 'success');
            redirect('backend/servicio/edit/'.$servicio->getCodigo());
        }

    }

    public function load_servicio_form(\Entities\Servicio $servicio, $esNuevo){
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findAll();

        $this->loadData('formAction', $esNuevo ? site_url('backend/servicio/create/') : site_url('backend/servicio/update/'.$servicio->getCodigo()));
        $this->loadData('servicio', $servicio);
        $this->loadData('servicios', $servicios);
        $this->loadData('entidades', $entidades);

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        $this->loadBlock('content', 'backend/servicio/form', $this->data);
        $this->renderView('backend/layout');
    }

    public function preparaMigracion($codigo = null){
        $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($codigo);
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findBy(array('publicado' => 1, 'oficial' => 1));

        if($this->get_post('seleccionar-todos-paginas', false)){
            $this->loadData('migracionCompleta', true);
        }else{
            $datasetsId = $this->get_post('dataset', null);
            $this->loadData('datasets', $this->doctrine->em->getRepository('Entities\Dataset')->findById($datasetsId));
            $this->loadData('migracionCompleta', false);
        }

        $this->loadData('servicio', $servicio);
        $this->loadData('servicios', $servicios);

        if($this->isAjax()){
            $this->renderView('backend/servicio/prepara_migracion');
        }else{
            $this->loadBlock('content', 'backend/servicio/prepara_migracion', $this->data);
            $this->renderView('backend/layout');
        }
    }

    public function migrar()
    {
        $codigo_origen = $this->get_post('codigo_origen', null);
        $codigo_destino = $this->get_post('codigo_destino', null);
        $datasetsId = $this->get_post('dataset', array());
        $actualizar_servicio_oficial = $this->get_post('actualizar_servicio_oficial', false);
        $migracionCompleta = $this->get_post('migracion-completa', false);

        if(!$codigo_destino){
            $this->addMessage('Debe seleccionar un servicio de destino para migrar los datasets.' , 'error');
            redirect('backend/servicio/view/'.$codigo_origen);
        }

        $servicio_origen = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($codigo_origen);
        $servicio_destino = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($codigo_destino);

        if(!$migracionCompleta){
            foreach ($datasetsId as $datasetId) {
                $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->find($datasetId);
                $this->doctrine->em->getRepository('Entities\Dataset')->migrarServicio($dataset, $servicio_destino);
            }
        }else{
            $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findBy(array('maestro' => true, 'servicio_codigo' => $codigo_origen));
            foreach ($datasets as $dataset) {
                $this->doctrine->em->getRepository('Entities\Dataset')->migrarServicio($dataset, $servicio_destino);
            }
        }

        if($actualizar_servicio_oficial){
            $servicio_origen->setServicioOficial($servicio_destino);

            $this->doctrine->em->persist($servicio_origen);
            $this->doctrine->em->flush();
        }

        $this->addMessage('Se han migrado los datasets desde el servicio ['.$servicio_origen->getNombre().'] al servicio ['.$servicio_destino->getNombre().']' , 'success');
        redirect('backend/servicio/view/'.$codigo_origen);
    }

    public function cambiaPublicacionDatasets($publicar = true)
    {
        $datasetsPublicados = array();
        $datasetsId = $this->get_post('dataset', array());
        $cambioCompleto = $this->get_post('seleccionar-todos-paginas', false);
        $codigoServicio = $this->get_post('codigo-servicio', null);

        if($cambioCompleto)
            $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findBy(array('servicio_codigo' => $codigoServicio, 'maestro' => 1));
        else
            $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findById($datasetsId);

        foreach ($datasets as $dataset) {
            $this->doctrine->em->getRepository('Entities\Dataset')->cambiarPublicacionUltimaVersion($dataset, $publicar == 1);
            $datasetsPublicados[] = $dataset->getId();
        }

        echo json_encode(array('error' => false, 'mensaje' => 'Se han publicado las versiones con id ['.implode(",",$datasetsPublicados).']', 'datasets' => $datasetsPublicados));
    }
}