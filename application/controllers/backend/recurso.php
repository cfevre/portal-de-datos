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

    public function junar($recurso_id = null)
    {
        if(!$recurso_id)
            show_404('No se ha encontrado la categoría solicitada.');

        $this->loadData('recurso', $this->doctrine->em->find('Entities\Recurso', $recurso_id));

        if($this->isAjax()){
            $this->renderView('backend/recurso/junar');
        }else{
            $this->loadBlock('content', 'backend/recurso/junar', $this->data);

            $this->renderView('backend/layout');
        }
    }

    public function enviarjunar($recurso_id = null)
    {
        set_time_limit(600);

        $recurso = $this->doctrine->em->find('Entities\Recurso', $recurso_id);
        $dataset = $recurso->getDataset();

        if(!$dataset->getMaestro()){
            $dataset = $dataset->getDatasetMaestro();
        }

        $junar_url = $this->config->item('junar_baseuri').'/datastreams/publish';
        $junar_authkey = $this->config->item('junar_authkey');

        $junarData['title'] = $this->get_post('title', '');
        $junarData['description'] = $this->get_post('description', '');
        $junarData['tags'] = $this->get_post('tags', '');
        $junarData['source'] = $recurso->getUrl();
        $junarData['category'] = $this->get_post('category', '');
        $junarData['meta_data'] = json_encode(array('cust-dataid' => $dataset->getId()));
        $junarData['table_id'] = 'table'.$this->get_post('table', '0');
        $junarData['auth_key'] = $junar_authkey;

        if($junarData['tags']){
            $junarData['tags'] = implode(',', $junarData['tags']);
        }

        $errores = $recurso->validateJunarData($junarData);

        if(!$errores){
            if($recurso->getJunarGuid()){
                $junarData['guid'] = $recurso->getJunarGuid();
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
                $recurso->setJunarGuid($result->id); //Se amarra el recurso con el dataset en junar
                $dataset->setIntegracionJunar(new DateTime()); //Se marca el dataset como enviado a junar

                $this->doctrine->em->persist($recurso);
                $this->doctrine->em->persist($dataset);

                $this->doctrine->em->flush();
            }else{
                $errores[] = array('recurso_id' => $recurso->getId(), 'recurso_descripcion' => $recurso->getDescripcion(), 'error' => $result->message.' ('.$result->error.')');
            }
        }

        echo json_encode(array(
            'error' => count($errores)?true:false,
            'message' => 'Recursos enviados a Junar',
            'callback' => 'dataset.callbackEnviaJunar('.$recurso_id.')',
            'errors' => $errores
        ));

        return true;
    }
}