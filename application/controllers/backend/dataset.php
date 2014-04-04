<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dataset extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('publicacion||ingreso');

		parent::__construct();

		$this->loadScript('page', site_url('assets/js/backend/dataset.js'));
	}
	
	public function index() {
        $this->load->library('pagination');

        $options['order_by'] = $this->get_post('orderby', 'd.id');
        $options['order_dir'] = $this->get_post('orderdir', 'desc');
        $options['offset'] = $this->get_post('offset', 0);
        $options['limit'] = 20;

        $options['codigo_entidad'] = $this->get_post('codigo_entidad', '');
        $options['codigo_servicio'] = $this->get_post('codigo_servicio', '');
        $options['titulo_dataset'] =  $this->get_post('q', null);
        $options['junar'] =  $this->get_post('junar', '');
        $options['con_recurso'] = $this->get_post('con_recurso', '');

        if($this->user->getInterministerial()){
            $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findAll();
            $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();
        }elseif($this->user->getMinisterial()){
            $entidades = null;
            $servicios = $this->user->getServicio()->getEntidad()->getServicio();
        }else{
            $entidades = null;
            $servicios = null;
        }

        $count = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetEntidadServicio(array_merge($options, array('total' => true)));

        if($this->input->get('excel', true)){
            ini_set('memory_limit', "256M");
            $id_maestros = array();
            $descargas_por_mes = array();
            //Arma arreglo con los meses a exportar (para descargas)
            $meses = stringsHelper::get_months('2011-09',date('Y-m'));

            //Obtiene los datasets
            $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetEntidadServicio($options);

            //Arma listado con los "id" de los maestros
            foreach ($datasets as $dataset) {
                $id_maestros[] = $dataset->getId();
            }

            //Se obtienen las descargas por cada mes
            foreach ($meses as $fecha) {
                list($ano, $mes) = explode('-',$fecha);
                $descargas_por_mes[$fecha] = $this->doctrine->em->getRepository('Entities\Dataset')->getDescargasDatasetsPeriodo(array('id_maestros' => $id_maestros, 'fecha_ano' => $ano, 'fecha_mes' => $mes));
                $vistas_por_mes[$fecha] = $this->doctrine->em->getRepository('Entities\Dataset')->getVistasDatasetsPeriodo(array('id_maestros' => $id_maestros, 'fecha_ano' => $ano, 'fecha_mes' => $mes));
            }
            $this->loadData('descargas_por_mes', $descargas_por_mes);
            $this->loadData('vistas_por_mes', $vistas_por_mes);
        }else{
            $datasets = $this->doctrine->em->getRepository('Entities\Dataset')->getDatasetEntidadServicio($options);
        }

        $pagination_config['base_url'] = base_url()
                    .'backend/dataset/?orderby='.$options['order_by']
                    .'&orderdir='.$options['order_dir']
                    .($options['codigo_servicio']?'&codigo_servicio='.$options['codigo_servicio']:'')
                    .($options['codigo_entidad']?'&codigo_entidad='.$options['codigo_entidad']:'')
                    .($options['junar']?'&junar='.$options['junar']:'')
                    .($options['con_recurso']?'&con_recurso='.$options['con_recurso']:'');

        $pagination_config['total_rows'] = $count;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);

        $this->loadData('offset', $options['offset']);
        $this->loadData('orderby', $options['order_by']);
        $this->loadData('orderdir', $options['order_dir']);
        $this->loadData('codigo_entidad', $options['codigo_entidad']);
        $this->loadData('codigo_servicio', $options['codigo_servicio']);
        $this->loadData('datasets', $datasets);
        $this->loadData('entidades', $entidades);
        $this->loadData('servicios', $servicios);
        $this->loadData('junar', $options['junar']);
        $this->loadData('con_recurso', $options['con_recurso']);
        $this->loadData('q', $options['titulo_dataset']);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        if($this->input->get('excel', true)){
            $this->loadData('filename', 'datasets');
            $this->loadBlock('content', 'backend/dataset/excel', $this->data);
            $this->renderView('backend/excel');
        }else{
            $this->loadBlock('content', 'backend/dataset/list', $this->data);
            $this->renderView('backend/layout');
        }
    }

	public function view($datasetId){
		$dataset = $this->doctrine->em->find('Entities\Dataset', $datasetId);

		$dataset->checkUserAccess();

		$this->loadData('dataset', $dataset);

		
		if($dataset->getMaestro()){
			$this->loadData('active', 'view');
			$this->loadBlock('content-navbar', 'backend/dataset/navbar', $this->data);
		}

		$this->loadBlock('content', 'backend/dataset/view', $this->data);
		$this->renderView('backend/layout');
	}

	public function versions($datasetId){
		$dataset = $this->doctrine->em->find('Entities\Dataset', $datasetId);
		$dataset->checkUserAccess();
		$versiones = $dataset->getDatasetVersion();

		$this->loadData('dataset', $dataset);
		$this->loadData('versiones', $versiones);

		if($dataset->getMaestro()){
			$this->loadData('active', 'versions');
			$this->loadBlock('content-navbar', 'backend/dataset/navbar', $this->data);
		}

		$this->loadBlock('content', 'backend/dataset/versions', $this->data);
		$this->renderView('backend/layout');	
	}

	public function history($datasetId){
		$dataset = $this->doctrine->em->find('Entities\Dataset', $datasetId);
		$dataset->checkUserAccess();

		$this->loadData('dataset', $dataset);

		if($dataset->getMaestro()){
			$this->loadData('active', 'history');
			$this->loadBlock('content-navbar', 'backend/dataset/navbar', $this->data);
		}

		$this->loadBlock('content', 'backend/dataset/history', $this->data);
		$this->renderView('backend/layout');	
	}

	public function edit($datasetId){
		$this->load_dataset_form($this->doctrine->em->find('Entities\Dataset', $datasetId), false);
	}

	public function add(){
		$this->load_dataset_form(new Entities\Dataset);
	}

	public function update(){
		$this->store_dataset($this->doctrine->em->find('Entities\Dataset', $this->input->post('id', true)), false);
	}

	public function create(){
		$this->store_dataset(new Entities\Dataset);
	}

	public function delete($datasetId){
		$dataset = $this->doctrine->em->find('Entities\Dataset', $datasetId);

		if($dataset->checkUserAccess('ingreso')){
			$this->doctrine->em->remove($dataset);
			$this->doctrine->em->flush();
			$this->addMessage('El Dataset ['.$datasetId.'] ha sido eliminado.', 'success');
		}

		redirect('backend/dataset');
	}

	function hashPassword($password){
		$salt = sha1(rand());
		$salted_password = sha1($password.$salt);
		return $salted_password.':'.$salt;
	}

	function store_dataset($dataset, $newDataset = true){
        $a_tags = array();

		$servicio = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($this->input->post('servicio_codigo', true));
		$categorias = $this->doctrine->em->getRepository('Entities\Categoria')->findBy(array('id' => $this->input->post('categorias', true)));
        $sectores = $this->doctrine->em->getRepository('Entities\Sector')->findByStringArray($this->input->post('sectores', true));
        $licencia = $this->doctrine->em->getRepository('Entities\Licencia')->findOneBy(array('id' => $this->input->post('licencia_id', true)));

        //Se debe validar que todos los tags existan
        $tags = $this->input->post('tags', true)?$this->input->post('tags', true):array();
        foreach($tags as $tag){
            $n_tag = $this->doctrine->em->getRepository('Entities\Tag')->findOneByNombre($tag);
            if(!$n_tag){
                $n_tag = new Entities\Tag;
                $n_tag->setNombre($tag);
                $n_tag->setUpdatedAt(new DateTime());
                $n_tag->setCreatedAt(new DateTime());

                $this->doctrine->em->persist($n_tag);
                $this->doctrine->em->flush();
            }
            $a_tags[] = $n_tag;
        }

		$dataset->setTitulo($this->input->post('titulo', true));
		$dataset->setDescripcion($this->input->post('descripcion')); //No se limpia esta variable ya que debe aceptar codigo html
		$dataset->setLicencia($licencia);
		$dataset->setFrecuencia($this->input->post('frecuencia', true));
		$dataset->setCoberturaTemporal($this->input->post('cobertura_temporal', true));
		$dataset->setGranularidad($this->input->post('granularidad', true));
		$dataset->setServicio($servicio);
		$dataset->updateCategorias($categorias);
		$dataset->updateTags($a_tags);
		$dataset->updateSectores($sectores);
		$dataset->setMaestro(true);
		$dataset->setActualizable(false);
		$dataset->setUpdatedAt(new DateTime());

		if($newDataset){
            $dataset->setDocId('');
			$dataset->setCreatedAt(new DateTime());
			$dataset->setPublicado(false);
		}

		$errors = $dataset->validate();

		if($errors){

			foreach($errors as $error){
				$this->addMessage($error);
			}
			
			$this->load_dataset_form($dataset, $newDataset);

		}else{

			$this->doctrine->em->persist($dataset);
			$this->doctrine->em->flush();
			
			//Se genera una version nueva del dataset
			$versionNueva = $dataset->generaVersion();

			$this->addMessage('Se ha grabado el dataset ['.$dataset->getId().']<br />La nueva versión generada es la ['.$versionNueva->getId().']' , 'success');

			redirect('backend/dataset');
		}
	}

	function load_dataset_form($dataset, $newDataset = true){
		$dataset->checkUserAccess('ingreso');
		$this->loadData('formAction', $newDataset?site_url('backend/dataset/create'):site_url('backend/dataset/update'));
		$this->loadData('dataset', $dataset);

		if(!$this->user->getMinisterial() && !$this->user->getInterministerial()){
			$servicios[] = $this->user->getServicio();
		}elseif(!$this->user->getInterministerial()){
			$servicios = $this->user->getServicio()->getEntidad()->getServicio();
		}else{
			$servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();	
		}

		$this->loadData('servicios', $servicios);
		$this->loadData('licencias', $this->doctrine->em->getRepository('Entities\Licencia')->findAll());
		$this->loadData('categorias', $this->doctrine->em->getRepository('Entities\Categoria')->findAll());

		if(!$newDataset && $dataset->getMaestro()){
			$this->loadData('active', 'edit');
			$this->loadBlock('content-navbar', 'backend/dataset/navbar', $this->data);
		}

		$this->loadBlock('content', 'backend/dataset/form', $this->data);

		$this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
		$this->loadScript('fineuploader', site_url('assets/js/fineuploader/jquery.fineuploader-3.0.min.js'));
		$this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));
		$this->loadStylesheet('fineuploader', site_url('assets/js/fineuploader/fineuploader.css'));
        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

		$this->renderView('backend/layout');
	}

	public function validaDataset($dataset){
		if(!$dataset->getTitulo())
			$this->addMessage('Debe ingresar un título para el dataset.', 'error');
		if(!$dataset->getDescripcion())
			$this->addMessage('Debe ingresar una descripción para el dataset.', 'error');
		if(!$dataset->getServicio())
			$this->addMessage('Debe seleccionar una institución para el dataset.', 'error');
		if(!$dataset->getLicencia())
			$this->addMessage('Debe seleccionar una licencia para el dataset.', 'error');
	}

	/*Ajax Calls*/
	public function togglePublicado($datasetId = null){
		if(!$this->isAjax())
			return false;
		if(!$datasetId)
			$datasetId = $this->input->get('id', true);

		if(!$this->user->hasRol('publicacion')){
			echo json_encode(array(
				'error' => true,
				'message' => 'No tiene permiso para publicar datasets'
			));
		}

		$dataset = $this->doctrine->em->find('Entities\Dataset', $datasetId);

		$id_version_previa = $dataset->togglePublicado();

		$callback = 'dataset.updatePublicadoButton('.$datasetId.','.($dataset->getPublicado()?'true':'false').')';
		if($id_version_previa)
			$callback .= ';dataset.updatePublicadoButton('.$id_version_previa.',false);';

		echo json_encode(array(
			'error' => false,
			'message' => 'Estado de publicación actualizado',
			'callback' => $callback
		));

		return true;
	}

    public function enviarjunar($dataset_id = null)
    {
        set_time_limit(600);

        // $dataset = $this->doctrine->em->find('Entities\Dataset', $dataset_id);
        $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->findOneBy(array('publicado' => 1, 'maestro_id' => $dataset_id));
        $errores = array();

        $junar_url = $this->config->item('junar_baseuri').'/datastreams/publish';
        $junar_authkey = $this->config->item('junar_authkey');

        foreach($dataset->getRecursos() as $recurso){
            if(in_array(mimeHelper::get_mime_name($recurso->getMime()), array('csv', 'xls'))){
                $dataRecurso = array(
                    'title' => $dataset->getTitulo().' - '.$recurso->getId(),
                    'description' => strip_tags($recurso->getDescripcion()),
                    'tags' => $dataset->getTagsString(),
                    'source' => $recurso->getUrl(),
                    'category' => 'Educación',
                    'meta_data' => json_encode(array('cust-dataid' => $dataset->getMaestroId())),
                    'table_id' => 'table0',
                    'auth_key' => $junar_authkey
                );

                if($recurso->getJunarGuid()){
                    $dataRecurso['guid'] = $recurso->getJunarGuid();
                }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $junar_url);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataRecurso);

                $result = json_decode(curl_exec($ch));

                if($result && isset($result->id)){
                    $recurso->setJunarGuid($result->id); //Se amarra el recurso con el dataset en junar
                    $dataset->setIntegracionJunar(new DateTime()); //Se marca el dataset como enviado a junar
                    $dataset->getDatasetMaestro()->setIntegracionJunar(new DateTime()); //Se marca el maestro como integrado en junar

                    $this->doctrine->em->persist($recurso);
                    $this->doctrine->em->persist($dataset);

                    $this->doctrine->em->flush();
                }else{
                    $errores[] = array('recurso_id' => $recurso->getId(), 'recurso_descripcion' => $recurso->getDescripcion(), 'error' => $result->message.' ('.$result->error.')');
                }
            }
        }

        if($dataset_id != null)
            $callback = 'dataset.callbackEnviaJunar('.$dataset_id.', '.json_encode($errores).')';
        else
            $callback = 'null';

        echo json_encode(array(
            'error' => false,
            'message' => 'Recursos enviados a Junar',
            'callback' => $callback
        ));

        return true;
    }
}