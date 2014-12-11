<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participa extends CIE_Controller {

    public function __construct(){
        parent::__construct();

        $this->loadScript('page', site_url('assets/js/participa.js'));
    }

    public function index(){
        $this->load->library('pagination');

        $options['limit'] = 8;
        $options['offset'] = $this->get_post('offset', 0);
        $options['orderby'] = $this->get_post('orderby', 'created_at');
        $options['orderdir'] = $this->get_post('orderdir', 'DESC');
        $options['filterby'] = $this->get_post('filterby', false);

        /*FILTRO*/
        if($options['filterby'] == 'procesado'){
            $options['orderby'] = 'created_at';
            $options['publicado'] = 1;
            $options['orderdir'] = 'DESC';
        }
        if($options['filterby'] == 'en_proceso'){
            $options['orderby'] = 'created_at';
            $options['publicado'] = 2;
            $options['orderdir'] = 'DESC';
        }
        if($options['filterby'] == 'no_procesado'){
            $options['orderby'] = 'created_at';
            $options['publicado'] = 0;
            $options['orderdir'] = 'DESC';
        }

        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'participa'));

        $participaciones = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);
        $options['total'] = true;
        $total = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);

        $pagination_config['base_url'] = site_url('participa?orderby='.$options['orderby'].'&orderdir='.$options['orderdir'].'&filterby='.$options['filterby']);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);
        
        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));
        
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
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria')->findBy(array('id' => $this->input->post('categoria', true)));

        $participacion = new Entities\Participacion;
        $participacion->setNombre($this->input->post('nombre', true));
        $participacion->setApellidos($this->input->post('apellidos', true));
        $participacion->setEmail($this->input->post('email', true));

        $participacion->setEdad($this->input->post('edad', true));
        $participacion->setRegion($this->input->post('region', true));
        $participacion->setOcupacion($this->input->post('ocupacion', true));

        $participacion->setTitulo($this->input->post('titulo', true));
        $participacion->setMensaje($this->input->post('mensaje', true));
        $participacion->setInstitucion($this->input->post('institucion', true));
        $participacion->updateCategorias($categorias);

        $participacion->setPublicado(3);
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
    public function rss(){
       $this->load->library('pagination');

        $options['limit'] = 20;
        $options['offset'] = $this->get_post('offset', 0);
        $options['orderby'] = $this->get_post('orderby', 'created_at');
        $options['orderdir'] = $this->get_post('orderdir', 'DESC');

        $participaciones = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);
        $options['total'] = true;
        $total = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);

        $pagination_config['base_url'] = site_url('participa?orderby='.$options['orderby'].'&orderdir='.$options['orderdir']);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);
        $this->output->set_header('Content-Type:application/xml');
        
        $this->loadData('orderby', $options['orderby']);
        $this->loadData('offset', $options['offset']);
        $this->loadData('limit', $options['limit']);
        $this->loadData('total', $total);

        $this->loadData('participaciones', $participaciones);

        $this->setPageTitle('RSS');

        $this->load->view('participa/rss', $this->data);
    }

    public function suscripcion($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $this->loadData('participacion', $participacion);

        $this->load->view('participa/suscripcion', $this->data);
    }
    public function ver($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findEntidad();
        $suscripcion = $this->doctrine->em->getRepository('Entities\Participacion')->subscriptionCount($participacionId);

        $this->loadData('participacion', $participacion);
        $this->loadData('servicios', $servicios);
        $this->loadData('entidades', $entidades);
        $this->loadData('suscripcion',$suscripcion);

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
    
    public function ingresoSuscripcion($participacionId){
        $suscripciones = $this->doctrine->em->getRepository('Entities\Participacion')->selectSubscription($participacionId);

        foreach ($suscripciones as $key => $suscripcion) {
            if ($suscripcion['email'] == $this->input->get('email', true)) {
                      echo json_encode(array('errors' => true, 'message' => 'Ya te encuentras suscrito a esta solicitud.'));

                      return false;
                  }
        }

        $suscripcion = new Entities\Suscripcion;

        $suscripcion->setParticipacionId($participacionId);
        $suscripcion->setEmail($this->input->get('email', true));

        $this->doctrine->em->persist($suscripcion);
        $this->doctrine->em->flush();

        $this->mailSuscripcion($this->input->get('email', true));

        echo json_encode(array('errors' => false, 'message' => 'Hemos recibido su información con exito.'));
        
        return true;
    }
    public function mailSuscripcion($suscripcion)
    {
        $this->load->library('email');

        $msg = 'Estimado(a) ,<br>'
            . 'ESTE MAIL SE HA ENVIADO AL MOMENTO DE SUSCRIBIRSE A UNA SOLICITUD DE DATOS';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($suscripcion);
        $this->email->subject('MAIL ENVIADO POR SUSCRIBIRSE');
        $this->email->message($msg);

        return $this->email->send();
    }
    /*METODO PARA USAR EN CRON. SE RECUERDA CADA 1 SEMANA A LOS CUSTOMERS QUE TIENEN SOLICITUDES PENDIENTES*/
    public function reminderMail(){
        $reminder = $this->doctrine->em->getRepository('Entities\Participacion')->reminderMail();
        $this->load->library('email');

        if(!$this->input->is_cli_request())
        {
            echo "Este metodo solo puede ser accesado via comando";
            return;
        }

        foreach ($reminder as $key => $usuario) {
            $msg = 'Estimado(a) ,<br>'
            . 'SE ENVIA ESTE MAIL PARA LAS PERSONAS QUE LLEVAN MAS DE 1 SEMANA SIN RESPONDER LA SOLICITUD';
            $this->email->from('datosabiertos@minsegpres.gob.cl');
            $this->email->to($usuario->getEmail());
            $this->email->subject('MAIL ENVIADO POR CRON');
            $this->email->message($msg); 
            $this->email->send();
        }
        return true;
    }
    /*FUNCION PARA USAR EN CRON. SE ENVIA AL FINAL DEL DÍA UN REPORTE VÍA MAIL AL ADMINISTRADOR INFORMANDO
    DE LAS PERSONAS QUE EFECTIVAMENTE INGRESARON LA URL DE LA SOLICITUD*/
    public function reminderDaily(){
        $reminder = $this->doctrine->em->getRepository('Entities\Participacion')->reminderDaily();
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findEntidad();

        $this->load->library('email');

        if(!$this->input->is_cli_request())
        {
            echo "Este metodo solo puede ser accesado via comando";
            return;
        }
        $msg = 'Estimado(a) ,<br>'
            . 'REPORTE DIARIO PARA EL ADMINISTRADOR <br>'
            . '<table>
                <thead>
                  <tr>
                     <th width="100">ID Participacion</th>
                     <th>Titulo</th>
                     <th>Descripcion</th>
                     <th>Institucion</th>
                  </tr>
                </thead>
                <tbody>';
        foreach ($reminder as $key => $usuario) {  
           $msg.= ' <tr>
                        <td>'. $usuario->getIdParticipacion() .'</td
                        <td>'. $usuario->getTitulo() .'</td>
                        <td>'. $usuario->getDescripcion() .'</td>
                        <td>'. $usuario->institucion($entidades) .'</td>
                    </tr>';
            }
            $msg .='</tbody>'
                  .'</table>';

            $this->email->from('datosabiertos@minsegpres.gob.cl');
            $this->email->to('');
            $this->email->subject('MAIL ENVIADO POR CRON');
            $this->email->message($msg); 

            return $this->email->send();
    }
}