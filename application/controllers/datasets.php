<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datasets extends CIE_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->enableCache();
        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl' => 'datasets'));

        $this->loadData('navItem', $navItem);

        $this->setPageTitle('Catalogo de Datos');

        $ndatasets = $this->doctrine->em->getRepository('Entities\Dataset')->getTotalDatasetsPublicados();

        $this->loadData('ndatasets', $ndatasets);

        $this->loadNavs();
        $this->loadBreadcrumb($this->data);
        $this->loadBlock('content', 'dataset/catalogo', $this->data);

        $this->loadScript('masonry', site_url('assets/js/libs/jquery.masonry.min.js'));


        $this->renderView('layout');
    }

    public function ver($maestroId = 0)
    {
        $this->enableCache();
        $this->load->library('Junar');

        $datasetMaestro = $this->doctrine->em->getRepository('Entities\Dataset')->find($maestroId);

        if (!$datasetMaestro || !$datasetMaestro->getMaestro())
            show_404('El dataset no ha sido encontrado.');

        $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetPublicado($datasetMaestro->getId());
        $recursos = $this->doctrine->em->getRepository('Entities\Recurso')->getRecursos($dataset->getId());
        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl' => 'datasets'));
        $tiposReporte = $this->doctrine->em->getRepository('Entities\TipoReporte')->findPublicos();

        $this->loadData('dataset', $dataset);
        $this->loadData('recursos', $recursos);
        $this->loadData('navItem', $navItem);
        $this->loadData('tiposReporte', $tiposReporte);

        $this->setPageTitle('Dataset - ' . $dataset->getTitulo());

        $this->loadNavs();

        $extra_crumbs[] = array('link' => '', 'title' => $dataset->getTitulo());

        $this->loadBreadcrumb($this->data, $extra_crumbs);

        /*JUNAR*/
        $authkey = $this->config->item('junar_authkey');
        $juarBaseUrl = $this->config->item('junar_baseuri');

        $meta = urlencode('{"cust-dataid":"' . $maestroId . '"}');
        $this->loadData('urlRecursosJunar', $juarBaseUrl . '/resources/search?meta=' . $meta . '&auth_key=' . $authkey);
        $this->loadData('urlVisualizacionesJunar', $juarBaseUrl . '/resources/search?resource=chart&auth_key=' . $authkey);

        $this->loadScript('highcharts', site_url('assets/js/highcharts/highcharts.js'));

        $this->loadBlock('content', 'dataset/ver', $this->data);

        $this->renderView('layout');
    }

    public function listar()
    {
        $this->load->library('pagination');

        $limit = 10;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
        $orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

        if ($orderby == 'titulo')
            $orderdir = 'ASC';

        $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(null, array($orderby => $orderdir), $limit, $offset);
        $total = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(array('total' => true), array($orderby => $orderdir), $limit, $offset);
        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl' => 'datasets'));

        $pagination_config['base_url'] = site_url('datasets/listar/?orderby=' . $orderby . '&orderdir=' . $orderdir);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $limit;

        $this->pagination->initialize($pagination_config);

        $this->loadData('navItem', $navItem);
        $this->loadData('datasets', $datasets);
        $this->loadData('orderby', $orderby);
        $this->loadData('offset', $offset);
        $this->loadData('limit', $limit);
        $this->loadData('total', $total);
        $this->loadData('pagination', $this->pagination->create_links());
        $this->loadData('list_title', 'Datasets');

        $this->setPageTitle('Datasets');

        $this->loadNavs();

        $this->loadBreadcrumb($this->data);

        $this->loadBlock('content', 'dataset/listar', $this->data);

        $this->renderView('layout');
    }

    public function rdf($maestroId)
    {
        $datasetMaestro = $this->doctrine->em->getRepository('Entities\Dataset')->find($maestroId);

        if (!$datasetMaestro->getMaestro()) {
            show_404('El dataset no ha sido encontrado.');
        }

        $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetPublicado($datasetMaestro->getId());
        $this->loadData('dataset', $dataset);

        header("Content-Type: application/rdf+xml");
        $this->load->view('dataset/rdf', $this->data);
    }

    public function rss($order = 'descargas', $limit = 4)
    {
        switch ($order) {
            case 'nuevos':
                $orderby = array('updated_at' => 'DESC');
                break;
            case 'evaluacion':
                $orderby = array('rating' => 'DESC');
                break;
            case 'nombre':
                $orderby = array('titulo' => 'ASC');
                break;
            default:
                $orderby = array('ndescargas' => 'DESC');
                break;
        }

        $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->findWithOrdering(null, $orderby, $limit);
        $this->loadData('datasets', $datasets);

        header("Content-Type: application/xml; charset=UTF-8");
        $this->load->view('dataset/rss', $this->data);
    }

    /*Ajax Calls*/
    public function ajax_get_descargas_stats($datasetId)
    {
        if (!$this->isAjax())
            return false;
        $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->find($datasetId);

        $estadistica = $this->doctrine->em->getRepository('Entities\Descarga')->getEstadisticaOfDataset($dataset);

        echo json_encode($estadistica);
    }

    public function ajax_add_hit($maestroId = 0)
    {

        $datasetMaestro = $this->doctrine->em->getRepository('Entities\Dataset')->find($maestroId);

        if (!$datasetMaestro->getPublicado())
            return;

        $fecha = date('Y-m-d');

        $vista = $this->doctrine->em->getRepository('Entities\Vista')->getByDatasetAndFecha($datasetMaestro->getId(), $fecha);

        if (!$vista)
            $vista = new Entities\Vista;

        $vista->setFecha(new DateTime());
        $vista->setCount($vista->getCount() + 1);
        $vista->setDataset($datasetMaestro);
        $this->doctrine->em->persist($vista);

        //Se incrementa el contador de visitas
        $datasetMaestro->setHits($datasetMaestro->getHits() + 1);
        $this->doctrine->em->persist($datasetMaestro);
        $this->doctrine->em->flush();

        echo json_encode(array('errors' => 0, 'mensaje' => 'Visitas actualizadas.'));
    }

    //Obtiene estadisticas con información de los datasets
    public function estadisticas()
    {
        $this->load->driver('cache');
        $content = array();

        $filtros['anio'] = $this->get_post('anio', null);
        $filtros['mes'] = $this->get_post('mes', null);
        $filtros['dia'] = $this->get_post('dia', null);
        $filtros['tipo'] = $this->get_post('tipo', 'publicaciones');

        if(!$content = $this->cache->get(current_url().'?'.$_SERVER['QUERY_STRING'])){

            switch ($filtros['tipo']) {
                case 'publicaciones';
                    $content = $this->estadisticas_publicaciones($filtros);
                    break;
                case 'descargas':
                    $content = $this->estadisticas_descargas($filtros);
                    break;
            }

            $this->cache->save(current_url().'?'.$_SERVER['QUERY_STRING'], $content, 86400); //1 día
        }

        //Se utiliza la salida de PHP como archivo csv
        $output = fopen('php://output', 'w');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=datasets_estadisticas_'.$filtros["tipo"].'.csv');

        foreach($content as $linea)
            fputcsv($output, $linea, "\t");
    }

    private function estadisticas_publicaciones($filtros = array())
    {
        $content = array();
        $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetConPublicaciones($filtros);

        //Se arma el encabezado
        $content[] = array(
            'id',
            'título',
            'estado',
            'ministerio',
            'institución',
            'fecha publicación'
        );

        foreach ($datasets as $dataset) {
            $fecha = $dataset['primeraVersionPublicada']['publicado_at'];
            $fecha = ($fecha instanceof DateTime) ? $fecha->format('d-m-Y') : 'no documentada';
            $content[] = array(
                $dataset['id'],
                $dataset['titulo'],
                ($dataset['publicado'] ? 'publicado' : 'no publicado'),
                $dataset['servicio']['entidad']['nombre'],
                $dataset['servicio']['nombre'],
                $fecha
            );
        }
        return $content;
    }

    private function estadisticas_descargas($filtros)
    {
        $content = array();
        $mestros_id = array();
        $descargas_por_mes = array();
        $vistas_por_mes = array();

        $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetConPublicaciones($filtros);

        $fecha_maxima = date('Y-m');

        if($filtros['anio']){
            if($filtros['mes']){
                $fecha_maxima = date('Y-m', strtotime($filtros['anio'].'-'.$filtros['mes']));
            }else{
                if($filtros['anio'] == date('Y')){
                    $fecha_maxima = date('Y-m');
                } else {
                    $fecha_maxima = date('Y-m', strtotime($filtros['anio'].'-12'));
                }
            }
        }

        $meses = stringsHelper::get_months(($filtros['anio'] ? $filtros['anio'] : '2011').'-'.($filtros['mes'] ? $filtros['mes'] : '01'),$fecha_maxima);

        //Se obtiene un arreglo con todos los ids obtenidos
        foreach($datasets as $dataset){
            $mestros_id[] = $dataset['id'];
        }

        foreach($meses as $fecha){
            list($ano, $mes) = explode('-',$fecha);
            $descargas_por_mes[$fecha] = $this->doctrine->em->getRepository('Entities\Dataset')->getDescargasDatasetsPeriodo(array('id_maestros' => $mestros_id, 'fecha_ano' => $ano, 'fecha_mes' => $mes));
            $vistas_por_mes[$fecha] = $this->doctrine->em->getRepository('Entities\Dataset')->getVistasDatasetsPeriodo(array('id_maestros' => $mestros_id, 'fecha_ano' => $ano, 'fecha_mes' => $mes));
        }

        //Se arma el encabezado
        $content[] = array_merge(array(
            'id',
            'título',
            'estado',
            'ministerio',
            'institución',
        ), $meses, array('total_descargas'), $meses, array('total_vistas'));

        foreach ($datasets as $dataset) {
            $descargas_meses = array();
            $descargas = 0;
            $vistas_meses = array();
            $vistas = 0;
            //Obtiene las descargas de cada mes
            foreach($meses as $fecha){
                if(isset($descargas_por_mes[$fecha][$dataset['id']]['total_descargas']))
                    $descargas = $descargas_por_mes[$fecha][$dataset['id']]['total_descargas'];
                $descargas_meses[] = $descargas;

                if(isset($vistas_por_mes[$fecha][$dataset['id']]['total_vistas']))
                    $vistas = $vistas_por_mes[$fecha][$dataset['id']]['total_vistas'];
                $vistas_meses[] = $vistas;
            }
            $descargas_meses[] = array_sum($descargas_meses);
            $vistas_meses[] = array_sum($vistas_meses);

            $content[] = array_merge(array(
                $dataset['id'],
                $dataset['titulo'],
                ($dataset['publicado'] ? 'publicado' : 'no publicado'),
                $dataset['servicio']['entidad']['nombre'],
                $dataset['servicio']['nombre']
            ), $descargas_meses, $vistas_meses);

        }

        return $content;
    }
}
