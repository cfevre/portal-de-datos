<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CIE_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function ajax_enviar_reporte()
    {
        $reporte = new Entities\Reporte;
        $dataset = $this->doctrine->em->find('Entities\Dataset', $this->input->get_post('denuncia-dataset_id', true));
        $tipoReporte = $this->doctrine->em->find('Entities\TipoReporte', $this->input->get_post('denuncia-tipo_reporte_id', true));

        $reporte->setDataset($dataset);
        $reporte->setTipoReporte($tipoReporte);
        $reporte->setEstado(1);
        $reporte->setOrigenPublico(1);
        $reporte->setComentarios( $this->input->get_post('denuncia-comentarios', true) );
        $reporte->setNombre( $this->input->get_post('denuncia-nombre', true) );
        $reporte->setEmail( $this->input->get_post('denuncia-email', true) );
        $reporte->setCreatedAt(new DateTime());
        
        $errors = $reporte->validate();

        if(!$errors){
            $this->config->load('recaptcha');
            $this->load->helper('recaptcha');

            $resp = recaptcha_check_answer($this->config->item('recaptcha_prikey'), $this->input->ip_address(), $this->input->get_post('recaptcha_challenge_field'), $this->input->get_post('recaptcha_response_field'));
            if (!$resp->is_valid) {
                $errors[] = 'Captcha inválido.';
            }
        }

        if(!$errors){
            $this->doctrine->em->persist($reporte);
            $this->doctrine->em->flush();

            echo json_encode(array('errors' => false, 'message' => 'Hemos recibido su información.'));
        }else{
            echo json_encode(array('errors' => $errors, 'message' => 'Ha ocurrido un error al ingresar sus datos.'));
        }

        return true;
    }
}
