<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documento extends CIE_Controller {

	function __construct(){

		$this->sectionRols = array('publicacion||ingreso');

		parent::__construct();

	}

	function index () {
		
	}

	function view ($documentoId) {
		
	}

	public function add($datasetId){
		$documento = new Entities\Documento;
		$documento->setDataset( $this->doctrine->em->find('Entities\Dataset', $datasetId) );
		$this->load_documento_form($documento);
	}

	public function edit($documentoId){
		$this->load_documento_form( $this->doctrine->em->find('Entities\Documento', $documentoId), false );
	}

	public function update($documentoId){
		$this->store_documento( $this->doctrine->em->find('Entities\Documento', $documentoId), false);
	}

	public function create($datasetId){
		$documento = new Entities\Documento;
		$documento->setDataset( $this->doctrine->em->find('Entities\Dataset', $datasetId) );
		$this->store_documento($documento);
	}

	public function delete($documentoId){

		$documento = $this->doctrine->em->find('Entities\Documento', $documentoId);
		$dataset = $documento->getDataset();

		$this->doctrine->em->remove($documento);
		$this->doctrine->em->flush();

		$nuevaVersion = $dataset->generaVersion(false);
		$nuevaVersion->createLog('<p>Modificación en <strong>Documentos</strong>:</p><ul><li>Documento id:['.$documentoId.'] eliminado</li></ul>');

		$callback = 'dataset.removeItem("documento", '.$documentoId.');';

		echo json_encode(array(
				'error' => false,
				'callback' => $callback
			));
	}

	public function load_documento_form($documento, $newDocumento = true){
		$this->loadData('documento', $documento);

		if($this->isAjax()){
			$this->renderView('backend/documento/form');
		}else{
			$this->loadBlock('content', 'backend/documento/form', $this->data);

			$this->loadScript('redactor', site_url('assets/js/redactor/redactor.min.js'));
			$this->loadScript('fineuploader', site_url('assets/js/fineuploader/jquery.fineuploader-3.0.min.js'));
			$this->loadStylesheet('redactor', site_url('assets/css/redactor/redactor.css'));
			$this->loadStylesheet('fineuploader', site_url('assets/js/fineuploader/fineuploader.css'));

			$this->renderView('backend/layout');
		}
	}

	public function store_documento($documento, $newDocumento = true){

		$entitySerializer = new \Doctrine\EntitySerializer($this->doctrine->em);

		if($newDocumento){
			$documento->setCreatedAt(new DateTime());
		}
		$documento->setTitulo( $this->input->get('titulo') );
		$documento->setDescripcion( $this->input->get('descripcion') );
		$documento->setUrl( $this->input->get('url'), true );
		$documento->setUpdatedAt( new DateTime() );
		$documento->fetchMetadata();

		$errors = $documento->validate();

		if($errors){

			echo json_encode(array('errors' => $errors));

		}else{

			$this->doctrine->em->persist($documento);
			$this->doctrine->em->flush();

			//Se genera una version nueva del dataset
			$nuevaVersion = $documento->getDataset()->generaVersion(false);
			$nuevaVersion->createLog('<p>Modificación en <strong>Documentos</strong>:</p><ul><li>Documento id:['.$documento->getId().'] creado</li></ul>');

			$callback = 'dataset.callbackGrabaItem({error: false}, "documento", '.json_encode($entitySerializer->toArray($documento)).')';

			echo json_encode(array(
				'errors' => false, 
				'callback' => $callback
			));
			
		}
	}

}