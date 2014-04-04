<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recursos extends CIE_Controller {

    public function __construct(){
        parent::__construct();
    }

  public function index() {

  }

  public function download($codigoRecurso){
    $recurso = $this->doctrine->em->getRepository('Entities\Recurso')->getPublicadoByCodigo($codigoRecurso);
    $dataset = $recurso->getDataset();

    if(!$dataset->getPublicado())
        return;

    $fecha = date('Y-m-d');

    $descarga = $this->doctrine->em->getRepository('Entities\Descarga')->getByRecursoAndFecha($recurso->getId(), $fecha);

    if(!$descarga)
        $descarga = new Entities\Descarga;

    $descarga->setFecha(new DateTime());
    $descarga->setCount($descarga->getCount()+1);
    $descarga->setRecurso($recurso);

    $this->doctrine->em->persist($descarga);
    $this->doctrine->em->flush();

    //Se actualiza el numero de descargas asociadas al Dataset
    $totalDescargas = $this->doctrine->em->getRepository('Entities\Dataset')->getTotalDescargas($dataset);
    $dataset->setNdescargas($totalDescargas);

    //Se actualiza el numero de descargas asociadas al Dataset Maestro
    $datasetMaestro = $dataset->getDatasetMaestro();
    $totalDescargasMaestro = $this->doctrine->em->getRepository('Entities\Dataset')->getTotalDescargas($datasetMaestro);
    $datasetMaestro->setNdescargas($totalDescargasMaestro);

    $this->doctrine->em->persist($dataset);
    $this->doctrine->em->persist($datasetMaestro);

    $this->doctrine->em->flush();

    header("Location: ".$recurso->getUrl());
  }

}
