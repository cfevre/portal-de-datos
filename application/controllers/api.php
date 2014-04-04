<?php
require(APPPATH.'libraries/REST_Controller.php');

class Api extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function datasets_get()
    {
        echo 1;
    }

    public function datasets_post()
    {
        $this->load->helper('array');
        $nombre_servicio = $this->post('servicio', true);

        if(!$nombre_servicio)
            $nombre_servicio = 'Servicio Temporal para carga mediante API';

        $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->getServicioPorNombre($nombre_servicio);

        //Si no existe un servicio con ese nombre, se debe crear un servicio temporal para aceptar el dataset
        if(!$servicio){
            $this->load->library('encrypt');

            $atributos_servicio['entidad_codigo'] = 'AA'; //Se usa el codigo de la presidencia para los servicios temporales
            $atributos_servicio['nombre'] = $nombre_servicio;
            $atributos_servicio['codigo'] = $this->encrypt->sha1($nombre_servicio);

            $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->creaServicio($atributos_servicio);
        }

        //Si el servicio tiene asociado otro servicio como oficial, se debe asignar este al dataset
        if($servicio->getServicioOficial())
            $servicio = $servicio->getServicioOficial();

        $data = $this->post();

        $data['servicio_codigo'] = $servicio->getCodigo();
        $data['tags'] = $this->post('etiquetas') ? explode(',', $this->post('etiquetas')) : array();
        //Si el servicio es oficial, entonces el dataset se marca como publicado
        $data['publicado'] = $servicio->getOficial() && $servicio->getPublicado();

        $dataset = null;

        if(element('doc_id', $data, null))
            $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->findOneBy(array('doc_id' => element('doc_id', $data, null), 'maestro' => 1));

        if(!$dataset)
            $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->creaDataset($data);
        else
            $dataset = $this->doctrine->em->getRepository('Entities\Dataset')->actualizaDataset($dataset, $data);

        $errors = $dataset->validate();

        if($errors){
            $this->response($errors);
        }else{
            $this->response($dataset->toArray());
        }
    }
}
?>