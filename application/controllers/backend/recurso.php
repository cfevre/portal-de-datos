<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recurso extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('publicacion||ingreso');

		parent::__construct();

	}

	function index () {
		
	}

	function view ($recursoId) {
		
	}

	public function add($datasetId){
		$recurso = new Entities\Recurso;
		$recurso->setDataset( $this->doctrine->em->find('Entities\Dataset', $datasetId) );
		$this->load_recurso_form($recurso);
	}

	public function edit($recursoId){
		$this->load_recurso_form( $this->doctrine->em->find('Entities\Recurso', $recursoId), false );
	}

	public function update($recursoId){
		$this->store_recurso( $this->doctrine->em->find('Entities\Recurso', $recursoId), false);
	}

	public function create($datasetId){
		$recurso = new Entities\Recurso;
		$recurso->setDataset( $this->doctrine->em->find('Entities\Dataset', $datasetId) );
		$this->store_recurso($recurso);
	}

	public function delete($recursoId){

		$recurso = $this->doctrine->em->find('Entities\Recurso', $recursoId);
		$dataset = $recurso->getDataset();

		$this->doctrine->em->remove($recurso);
		$this->doctrine->em->flush();

		$nuevaVersion = $dataset->generaVersion(false);
		$nuevaVersion->createLog('<p>Modificación en <strong>Recursos</strong>:</p><ul><li>Recurso id:['.$recursoId.'] eliminado</li></ul>');

		$callback = 'dataset.removeItem("recurso", '.$recursoId.');';

		echo json_encode(array(
				'error' => false,
				'callback' => $callback
			));
	}

	public function load_recurso_form($recurso, $newRecurso = true){
		$this->loadData('recurso', $recurso);

		if($this->isAjax()){
			$this->renderView('backend/recurso/form');
		}else{
			$this->loadBlock('content', 'backend/recurso/form', $this->data);

			$this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
			$this->loadScript('fineuploader', site_url('assets/js/fineuploader/jquery.fineuploader-3.0.min.js'));
			$this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));
			$this->loadStylesheet('fineuploader', site_url('assets/js/fineuploader/fineuploader.css'));

			$this->renderView('backend/layout');
		}
	}

	public function store_recurso($recurso, $newRecurso = true){

		$entitySerializer = new \Doctrine\EntitySerializer($this->doctrine->em);

        $this->doctrine->em->getConnection()->beginTransaction();

		if($newRecurso){
			$recurso->setCodigo(1+$this->doctrine->em->getRepository('Entities\Recurso')->getMaxCodigo());
			$recurso->setCreatedAt(new DateTime());
		}
		$recurso->setDescripcion( $this->input->get('descripcion') );
		$recurso->setUrl( $this->input->get('url'), true );
		$recurso->setUpdatedAt( new DateTime() );
		$recurso->fetchMetadata();

		$errors = $recurso->validate();

		if($errors){

			echo json_encode(array('errors' => $errors));

		}else{

			$this->doctrine->em->persist($recurso);
			$this->doctrine->em->flush();

			//Se genera una version nueva del dataset
			$nuevaVersion = $recurso->getDataset()->generaVersion(false);
			$nuevaVersion->createLog('<p>Modificación en <strong>Recursos</strong>:</p><ul><li>Recurso id:['.$recurso->getId().'] creado</li></ul>');

			$callback = 'dataset.callbackGrabaItem({error: false}, "recurso", '.json_encode($entitySerializer->toArray($recurso)).')';

			echo json_encode(array(
				'errors' => false, 
				'callback' => $callback
			));
			
		}
        $this->doctrine->em->getConnection()->commit();
	}

    public function crearVistaJunar($recurso_id = null){
        if(!$recurso_id)
            show_404('No se ha encontrado el recurso asociado.');

        $recurso = $this->doctrine->em->find('Entities\Recurso', $recurso_id);
        $vista_junar = new Entities\VistaJunar();
        $vista_junar->setRecurso($recurso);
        $vista_junar->setSource($recurso->getUrl());
        $vista_junar->setTitle($recurso->getDataset()->getTitulo());
        $vista_junar->setDescription(stringsHelper::truncate_string($recurso->getDescripcion(), 77));

        $this->loadData('vista_junar', $vista_junar);

        if($this->isAjax()){
            $this->renderView('backend/recurso/junar');
        }else{
            $this->loadBlock('content', 'backend/recurso/junar', $this->data);

            $this->renderView('backend/layout');
        }
    }

    public function editarVistaJunar($vista_junar_id = null)
    {
        if(!$vista_junar_id)
            show_404('No se ha encontrado la vista solicitada.');

        $this->loadData('vista_junar', $this->doctrine->em->find('Entities\VistaJunar', $vista_junar_id));

        if($this->isAjax()){
            $this->renderView('backend/recurso/junar');
        }else{
            $this->loadBlock('content', 'backend/recurso/junar', $this->data);

            $this->renderView('backend/layout');
        }
    }

    public function guardarvistajunar($vista_junar_id = null){
        if($vista_junar_id == 0){
            $vistaJunar = new Entities\VistaJunar();
            $recurso = $this->doctrine->em->find('Entities\Recurso', $this->get_post('recurso_id'));
            $vistaJunar->setRecurso($recurso);
            $vistaJunar->setJunarGuid('');
            $vistaJunar->setCreatedAt(new DateTime());
        }else
            $vistaJunar = $this->doctrine->em->find('Entities\VistaJunar', $vista_junar_id);

        $dataset = $vistaJunar->getRecurso()->getDataset();

        if(!$dataset->getMaestro())
            $dataset = $dataset->getDatasetMaestro();

        $vistaJunar->setTitle($this->get_post('title', ''));
        $vistaJunar->setDescription($this->get_post('description', ''));
        $vistaJunar->setCategory($this->get_post('category', ''));
        $vistaJunar->setTags(implode(',',$this->get_post('tags', array())));
        $vistaJunar->setSource($this->get_post('source', ''));
        $vistaJunar->setMetaData($dataset->getId());
        $vistaJunar->setTableId($this->get_post('table_id', 0));
        $vistaJunar->setUpdatedAt(new DateTime());

        $errors = $vistaJunar->validate();

        if($errors){
            echo json_encode(array('errors' => $errors));
        } else {
            $entitySerializer = new \Doctrine\EntitySerializer($this->doctrine->em);

            $this->doctrine->em->persist($vistaJunar);
            $this->doctrine->em->flush();

            $callback = 'dataset.callbackGuardaVistaJunar({error: false}, '.json_encode($entitySerializer->toArray($vistaJunar)).')';

            echo json_encode(array(
                'errors' => false,
                'callback' => $callback
            ));
        }
    }

    public function enviarVistaJunar($vista_junar_id = null)
    {
        set_time_limit(600);

        $vistaJunar = $this->doctrine->em->find('Entities\VistaJunar', $vista_junar_id);
        $recurso = $vistaJunar->getRecurso();
        $dataset = $recurso->getDataset();

        if(!$dataset->getMaestro()){
            $dataset = $dataset->getDatasetMaestro();
        }

        $junar_url = $this->config->item('junar_baseuri').'/datastreams/publish';
        $junar_authkey = $this->config->item('junar_authkey');

        $junarData['title'] = $vistaJunar->getTitle();
        $junarData['description'] = $vistaJunar->getDescription();
        $junarData['tags'] = $vistaJunar->getTags();
        $junarData['source'] = $vistaJunar->getSource();
        $junarData['category'] = $vistaJunar->getCategory();
        $junarData['meta_data'] = json_encode(array('cust-dataid' => $dataset->getId()));
        $junarData['table_id'] = 'table'.$vistaJunar->getTableId();
        $junarData['auth_key'] = $junar_authkey;

        $errores = $recurso->validateJunarData($junarData);

        if(!$errores){
            if($vistaJunar->getJunarGuid()){
                $junarData['guid'] = $vistaJunar->getJunarGuid();
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $junar_url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 90);
            curl_setopt($ch, CURLOPT_TIMEOUT, 90);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $junarData);

            $result = json_decode(curl_exec($ch));

            if($result && isset($result->id)){
                $vistaJunar->setJunarGuid($result->id); //Se amarra el recurso con el dataset en junar
                $dataset->setIntegracionJunar(new DateTime()); //Se marca el dataset como enviado a junar

                $this->doctrine->em->persist($recurso);
                $this->doctrine->em->persist($dataset);

                $this->doctrine->em->flush();
            }else{
                $errores[] = array('vista_junar_id' => $vistaJunar->getId(), 'vista_junar_description' => $vistaJunar->getDescription(), 'error' => $result->message.' ('.$result->error.')');
            }
        }

        echo json_encode(array(
            'error' => count($errores)?true:false,
            'message' => 'Vista enviada a Junar',
            'callback' => 'dataset.callbackEnviaJunar('.$vista_junar_id.')',
            'errors' => $errores
        ));

        return true;
    }

    public function deleteVistaJunar($vista_junar_id){
        $vistaJunar = $this->doctrine->em->find('Entities\VistaJunar', $vista_junar_id);

        $this->doctrine->em->remove($vistaJunar);
        $this->doctrine->em->flush();

        $callback = 'dataset.removeItem("vistaJunar", '.$vista_junar_id.');';

        echo json_encode(array(
            'error' => false,
            'callback' => $callback
        ));
    }

    public function ajax_fila_vista_junar($vista_junar_id){
        $this->loadData('vistaJunar', $this->doctrine->em->find('Entities\VistaJunar', $vista_junar_id));
        $this->renderView('backend/recurso/tr_vista_junar');
    }
}