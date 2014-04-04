<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluaciones extends CIE_Controller {

	public function __construct(){
		parent::__construct();
	}

	function evaluar ($datasetId) {
		$dataset = $this->doctrine->em->getRepository('Entities\Dataset')->find($datasetId);

		if(!$dataset){
			echo json_encode(array( 'error' => true, 'mensaje' => 'Dataset invalido' ));
			exit;
		}
		
		if(!$this->_canEvaluar($dataset)){
			echo json_encode(array( 'error' => true, 'mensaje' => 'No puede votar' ));
			exit;
		}

		$rating = floatval($this->input->get('rating', true));

		//Se crea una nueva evaluación
    $evaluacion = new Entities\Evaluacion;
    $evaluacion->setRating($rating);
    $evaluacion->setDataset($dataset);
    $evaluacion->setCreatedAt(new DateTime());
    $evaluacion->setUpdatedAt(new DateTime());
    $this->doctrine->em->persist($evaluacion);
    $this->doctrine->em->flush();

    //Se actualiza el rating del dataset
    $newRating = $this->doctrine->em->getRepository('Entities\Dataset')->getPromedioEvaluaciones($dataset);
    $dataset->setRating($newRating);
		$this->doctrine->em->persist($dataset);
    $this->doctrine->em->flush();    

    //Se actualiza el rating del dataset maestro
    $newRating = $this->doctrine->em->getRepository('Entities\Dataset')->getPromedioEvaluaciones($dataset->getDatasetMaestro());
    $dataset->getDatasetMaestro()->setRating($newRating);
		$this->doctrine->em->persist($dataset->getDatasetMaestro());
    $this->doctrine->em->flush();        

    //Actualizamos la cookie para que no vuelva a votar
    $evaluados=json_decode($this->input->cookie('evaluados'));
    if(!$evaluados || !in_array($evaluacion->getDataset()->getDatasetMaestro()->getId(), $evaluados)){
        $evaluados[] = $evaluacion->getDataset()->getDatasetMaestro()->getId();
        $cookie = array(
            'name' => 'evaluados',
            'value' => json_encode($evaluados),
            'expire' => '3153600'
        );
    }
    $this->input->set_cookie($cookie);

    echo json_encode(array( 'error' => false, 'mensaje' => 'Dataset evaluado' ));
    exit;
	}

	function _canEvaluar($dataset){
		$evaluados = json_decode($this->input->cookie('evaluados'));

		if(!$evaluados || !in_array($dataset->getDatasetMaestro()->getId(), $evaluados))
			return true;

		return false;
	}

}
