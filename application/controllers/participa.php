<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participa extends CIE_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load->library('pagination');

        $options['limit'] = 8;
        $options['offset'] = $this->get_post('offset', 0);
        $options['orderby'] = $this->get_post('orderby', 'created_at');
        $options['orderdir'] = $this->get_post('orderdir', 'DESC');

        if($options['orderby'] == 'titulo'){
            $options['orderdir'] = 'ASC';
        }

        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'participa'));

        $participaciones = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);
        $options['total'] = true;
        $total = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);

        $pagination_config['base_url'] = site_url('participa?orderby='.$options['orderby'].'&orderdir='.$options['orderdir']);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);
          
        $this->loadData('orderby', $options['orderby']);
        $this->loadData('offset', $options['offset']);
        $this->loadData('limit', $options['limit']);
        $this->loadData('total', $total);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadData('navItem', $navItem);
        $this->loadData('participaciones', $participaciones);

        $this->setPageTitle('Participa');

        $this->loadNavs();
        $this->loadBreadcrumb($this->data);
        $this->loadBlock('content', 'participa/participa', $this->data);

        $this->renderView('layout');
    }

    public function add(){
        
        $participacion = new Entities\Participacion;
        $participacion->setNombre($this->input->post('nombre', true));
        $participacion->setApellidos($this->input->post('apellidos', true));
        $participacion->setEmail($this->input->post('email', true));
        $participacion->setTitulo($this->input->post('titulo', true));
        $participacion->setCategoria($this->input->post('categoria', true));
        $participacion->setMensaje($this->input->post('mensaje', true));
        $participacion->setPublicado(false);
        $participacion->setCreatedAt(new DateTime());
        $participacion->setUpdatedAt(new DateTime());

        $errors = $participacion->validate();

        if(!$errors){
            $this->config->load('recaptcha');
            $this->load->helper('recaptcha');

            $resp = recaptcha_check_answer($this->config->item('recaptcha_prikey'), $this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $this->input->post('recaptcha_response_field'));
            if (!$resp->is_valid) {
                $errors[] = 'Captcha inválido.';
            }
        }

        if(!$errors){
            $this->doctrine->em->persist($participacion);
            $this->doctrine->em->flush();

            $this->_envia_mail_participacion($participacion);

            echo json_encode(array('errors' => false, 'message' => 'Hemos recibido su información.'));
        }else{
            echo json_encode(array('errors' => $errors, 'message' => 'Ha ocurrido un error al ingresar sus datos.'));
        }
        return true;
    }

    public function ver($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $this->loadData('participacion', $participacion);

        $this->load->view('participa/ver', $this->data);
    }

    public function _envia_mail_participacion($participacion)
    {
        $this->load->library('email');

        $msg = 'Estimado(a) '.$participacion->getNombre(). ',<br>'
            . 'Agradecemos tu participación, para nosotros es importante conocer tu opinión, sugerencia y/o solicitud, de manera que mejoremos en conjunto el Portal de Datos Abiertos.<br><br>'
            . 'Te contactaremos en caso de requerir más información.<br><br>'
            . 'Saludos,<br>'
            . 'Equipo Datos Abiertos';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participacion->getEmail());
        $this->email->subject('Gracias por participar');
        $this->email->message($msg);
        


        return $this->email->send();
    }

}
