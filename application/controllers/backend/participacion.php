<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participacion extends CIE_Controller {

    function __construct(){

        $this->sectionRols = array('publicacion||ingreso');

        parent::__construct();
        $this->loadScript('page', site_url('assets/js/backend/participacion.js'));
    }
    
    public function index() {
        $this->load->library('pagination');

        $options['limit'] = 10;
        $options['offset'] = $this->get_post('offset', 0);
        $options['orderby'] = $this->get_post('orderby', 'created_at');
        $options['orderdir'] = $this->get_post('orderdir', 'DESC');
        $options['excel'] = $this->get_post('excel', null);
        $options['all'] = true;

        $participaciones = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);
        $options['total'] = true;
        $total = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrdering($options);
        $solicitudPendiente = $this->doctrine->em->getRepository('Entities\Participacion')->solicitudPendiente($this->user->getServicio()->getCodigo());

        $pagination_config['base_url'] = site_url('backend/participacion/?orderby='.$options['orderby'].'&orderdir='.$options['orderdir']);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $options['limit'];

        $this->pagination->initialize($pagination_config);
      
        $this->loadData('orderby', $options['orderby']);
        $this->loadData('orderdir', $options['orderdir']);
        $this->loadData('offset', $options['offset']);
        $this->loadData('limit', $options['limit']);
        $this->loadData('total', $total);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        $this->loadData('participaciones', $participaciones);
        $this->loadData('solicitudPendiente', $solicitudPendiente);

        $this->setPageTitle('Participaciones');

        if($options['excel']){
            $this->loadData('filename', 'participaciones');
            $this->loadBlock('content', 'backend/participacion/excel', $this->data);
            $this->renderView('backend/excel');
        }else{
            $this->loadBlock('content', 'backend/participacion/list', $this->data);
            $this->renderView('backend/layout');
        }

    }

    public function view($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findEntidad();
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();

        $this->loadData('participacion', $participacion);
        $this->loadData('servicios', $servicios);
        $this->loadData('entidades', $entidades);

        $this->loadData('active', 'view');
        $this->loadBlock('content-navbar', 'backend/participacion/navbar', $this->data);
        

        $this->loadBlock('content', 'backend/participacion/view', $this->data);
        $this->renderView('backend/layout');
    }
    public function edit($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $servicios = $this->doctrine->em->getRepository('Entities\Servicio')->findAll();
        $parti = $this->doctrine->em->getRepository('Entities\Participacion')->userMailSend($participacion->getInstitucion());
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findEntidad();

        $this->loadData('participacion', $participacion);
        $this->loadData('servicios', $servicios);
        $this->loadData('parti', $parti);
        $this->loadData('entidades', $entidades);

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        $this->loadData('active', 'edit');
        $this->loadBlock('content-navbar', 'backend/participacion/navbar', $this->data);
        

        $this->loadBlock('content', 'backend/participacion/edit', $this->data);
        $this->renderView('backend/layout');
    }
    public function delete($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

            $this->doctrine->em->remove($participacion);
            $this->doctrine->em->flush();
            $this->addMessage('La solicitud ['.$participacionId.'] ha sido eliminada.', 'success');

        redirect('backend/participacion');
    }

    /*Ajax Calls*/
    public function togglePublicado($participacionId = null){
        if(!$this->isAjax())
            return false;
        if(!$participacionId)
            $participacionId = $this->input->get('id', true);

        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $participacion->setPublicado(!$participacion->getPublicado());
        $this->doctrine->em->persist($participacion);
        $this->doctrine->em->flush();

        $callback = 'participacion.updatePublicadoButton('.$participacionId.','.($participacion->getPublicado()).')';

        echo json_encode(array(
            'error' => false,
            'message' => 'Estado de publicación actualizado',
            'callback' => $callback
        ));

        return true;
    }
    /*Cambiar estado de la solicitud*/
    public function cambiarEstado($participacionId , $participacionEstado){
        $parti = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $estadoAnterior = $parti->getPublicado();
        $parti->setPublicado($participacionEstado);
        $parti->setUpdatedAt(new DateTime());

        $this->doctrine->em->persist($parti);
        $this->doctrine->em->flush();

        $callback = 'participacion.updatePublicadoButton('.$participacionId.','.$parti->getPublicado().','.$estadoAnterior.')';

        $this->envia_mail_solicitudes($participacionId);

        echo json_encode(array(
            'error' => false,
            'message' => 'Estado de publicación actualizado',
            'callback' => $callback
        ));
        return true;
    }

    /*Actualizar solicitud de datos*/
    public function actualizarSolicitud($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion',$participacionId);

        $participacion->setNombre($this->input->post('nombre', true));
        $participacion->setApellidos($this->input->post('apellido', true));
        $participacion->setEmail($this->input->post('email', true));

        $participacion->setEdad($this->input->post('edad', true));
        $participacion->setRegion($this->input->post('region', true));
        $participacion->setOcupacion($this->input->post('ocupacion', true));

        $participacion->setTitulo($this->input->post('titulo', true));
        $participacion->setMensaje($this->input->post('mensaje', true));
        $participacion->setInstitucion($this->input->post('servicio_codigo', true));
        $participacion->setCategoria($this->input->post('categoria', true));

        //$participacion->setVotacion($this->input->post('votacion', true));
        $participacion->setEnlace($this->input->post('enlace', true));

        $participacion->setUpdatedAt(new DateTime());

        $errors = $participacion->validate();

        if(!$errors){
            $this->doctrine->em->persist($participacion);
            $this->doctrine->em->flush();           

             $this->addMessage('La solicitud #'.$participacionId.' ha sido actualizada con éxito.', 'success');
        }else{
            $this->addMessage('La solicitud #'.$participacionId.' no se ha podido actualizar.', 'danger');
        }

        redirect('backend/participacion');
    }
    public function envia_mail_solicitudes($participacionId)
    {
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $parti = $this->doctrine->em->getRepository('Entities\Participacion')->userMailSend($participacion->getInstitucion());
        $this->load->library('email');

        $this->loadData('parti', $parti);

        foreach ($parti as $key => $participantes) {
            . 'Agradecemos tu participación, para nosotros es importante conocer tu opinión, sugerencia y/o solicitud, de manera que mejoremos en conjunto el Portal de Datos Abiertos.<br><br>'
            . 'Te contactaremos en caso de requerir más información.<br><br>'
            . 'Saludos,<br>'
            . 'Equipo Datos Abiertos';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participantes->getEmail());
        $this->email->subject('Esto es una prueba');
        $this->email->message($msg);
        }

        return $this->email->send();
    }
}