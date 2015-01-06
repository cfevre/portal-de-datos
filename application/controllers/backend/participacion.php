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
        $options['servicio'] = $this->user->getServicio()->getCodigo();
        $options['admin'] = false;
        if ($this->user->hasRol('publicacion')&&$this->user->hasRol('cms')
            &&$this->user->hasRol('ingreso')&&$this->user->hasRol('mantencion')) {
           $options['admin'] = true;
        }

        $participaciones = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrderingBack($options);
        $options['total'] = true;
        $total = $this->doctrine->em->getRepository('Entities\Participacion')->findWithOrderingBack($options);
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
        $suscripcion = $this->doctrine->em->getRepository('Entities\Participacion')->subscriptionCount($participacionId);

        $this->loadData('participacion', $participacion);
        $this->loadData('servicios', $servicios);
        $this->loadData('entidades', $entidades);
        $this->loadData('suscripcion',$suscripcion);

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
        $suscripcion = $this->doctrine->em->getRepository('Entities\Participacion')->subscriptionCount($participacionId);

        $this->loadData('participacion', $participacion);
        $this->loadData('servicios', $servicios);
        $this->loadData('parti', $parti);
        $this->loadData('entidades', $entidades);
        $this->loadData('suscripcion',$suscripcion);

        $this->loadScript('chosen', site_url('assets/js/chosen/chosen.jquery.min.js'));
        $this->loadStylesheet('chosen', site_url('assets/js/chosen/chosen.css'));

        $this->loadData('active', 'edit');
        $this->loadBlock('content-navbar', 'backend/participacion/navbar', $this->data);
        

        $this->loadBlock('content', 'backend/participacion/edit', $this->data);
        $this->renderView('backend/layout');
    }
    /*Funcion para borrar una solicitud no apropiada*/
    public function delete($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

            $this->doctrine->em->remove($participacion);
            $this->doctrine->em->flush();
            $this->addMessage('La solicitud ['.$participacionId.'] ha sido eliminada.', 'success');

        redirect('backend/participacion');
    }
    /*Cambiar estado de la solicitud a EN PROCESO*/
    public function cambiarEstado($participacionId , $participacionEstado){
        $parti = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $parti->setPublicado($participacionEstado);
        $parti->setUpdatedAt(new DateTime());

        $this->doctrine->em->persist($parti);
        $this->doctrine->em->flush();

        $this->envia_mail_solicitudes($participacionId);
        $this->envia_mail_solicitante($participacionId);

        $this->addMessage('Se ha actualizado la solicitud, #'.$participacionId.'.', 'success');

        redirect('backend/participacion');
    }
     /*Cambiar estado de la solicitud a ESPERA DE APROBACION*/
    public function cambiarEstadoProceso($participacionId , $participacionEstado){
        $parti = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        if (!$parti->getEnlace()) {
            if (!$this->input->post('enlace_modal', true)) {
                $this->addMessage('Debes ingresar un enlace para la solicitud, #'.$participacionId.'.', 'danger');
                redirect('backend/participacion');
            }else{
                $parti->setEnlace($this->input->post('enlace_modal', true));
            }
        }

        $parti->setPublicado($participacionEstado);
        $parti->setUpdatedAt(new DateTime());

        //$this->doctrine->em->persist($parti);
        //$this->doctrine->em->flush();

        $this->addParticipacionEmail($participacionId);
        $this->envia_mail_solicitudes($participacionId);

        $this->addMessage('Se ha actualizado la solicitud, #'.$participacionId.'.', 'success');

        redirect('backend/participacion');
    }
    /*Actualizar solicitud de datos*/
    public function actualizarSolicitud($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion',$participacionId);
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria')->findBy(array('id' => $this->input->post('categoria', true)));
        $servicio = $this->doctrine->em->getRepository('Entities\Servicio')->findOneByCodigo($this->input->post('servicio_codigo', true));

        $participacion->setNombre($this->input->post('nombre', true));
        $participacion->setApellidos($this->input->post('apellido', true));
        $participacion->setEmail($this->input->post('email', true));

        $participacion->setEdad($this->input->post('edad', true));
        $participacion->setRegion($this->input->post('region', true));
        $participacion->setOcupacion($this->input->post('ocupacion', true));

        $participacion->setTitulo($this->input->post('titulo', true));
        $participacion->setMensaje($this->input->post('mensaje', true));
        $participacion->setServicio($servicio);
        $participacion->updateCategorias($categorias);

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
    /*Se envia un mail a todas las personas asociadas al servicio de la solicitud*/
    public function envia_mail_solicitudes($participacionId)
    {
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $parti = $this->doctrine->em->getRepository('Entities\Participacion')->userMailSend($participacion->getInstitucion());
        $suscriptionCount= $this->doctrine->em->getRepository('Entities\Participacion')->subscriptionCount($participacionId);
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findEntidad();

        $this->load->library('email');

        $this->loadData('parti', $parti);
        $this->loadData('suscriptionCount', $suscriptionCount);

        $sendMail = array();

        foreach ($parti as $key => $participantes) {
            $msg = 'Estimado(a) '.$participacion->getNombre(). ',<br/>'
            . '<table>
                <tbody>
                    <tr>
                        <th width="150">Estado</th>
                        <td>'.$participacion->publicado_mail() .'</td>
                    </tr>
                    <tr>
                        <th>Titulo Peticion</th>
                        <td>'. $participacion->getTitulo() .'</td>
                    </tr>
                    <tr>
                        <th>Descripcion</th>
                        <td>'. $participacion->getMensaje() .'</td>
                    </tr>
                    <tr>
                        <th>Institucion</th>
                        <td>'.$participacion->getServicio()->getNombre().'</td>
                    </tr>
                    <tr>
                        <th>Fecha de Creacion</th>
                        <td>'. $participacion->getCreatedAt()->format('d/m/Y  H:i') .'</td>
                    </tr>
                    <tr>
                        <th>Votacion</th>
                        <td>'. $participacion->votacion($suscriptionCount) .'</td>
                    </tr>
                </tbody>
            </table>';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participantes->getEmail());
        $this->email->subject('Esto es una prueba de cambio de estado');
        $this->email->message($msg);
        $sendMail = $this->email->send();
        }

        return true;
    }
    /*Se envia un mail al ciudadano solicitante.*/
    public function envia_mail_solicitante($participacionId){
       $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $this->load->library('email');
        $this->loadData('participacion', $participacion);

        $msg = 'Estimado(a),<br>'
        . 'Este mail se envia a la persona que hizo la solicitud de datos<br><br>';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participacion->getEmail());
        $this->email->subject('Mail que se le envia al solicitante');
        $this->email->message($msg);
        $this->email->send();

        return true;
    }
    /*Funcion para recordar semanalmente que la solicitud se encuentra en estado En Proceso*/
     public function recordatorioMail ($participacionId)
    {
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $parti = $this->doctrine->em->getRepository('Entities\Participacion')->userMailSend($participacion->getInstitucion());
        $suscriptionCount= $this->doctrine->em->getRepository('Entities\Participacion')->subscriptionCount($participacionId);
        $entidades = $this->doctrine->em->getRepository('Entities\Entidad')->findEntidad();

        $this->load->library('email');

        $this->loadData('parti', $parti);
        $this->loadData('suscriptionCount', $suscriptionCount);

        foreach ($parti as $key => $participantes) {
            $msg = 'Estimado(a) '.$participacion->getNombre().' Se le recuerda que la petición esta aún sin solucion,<br>'
            . '<table>
                <tbody>
                    <tr>
                        <th width="150">Estado</th>
                        <td>'.$participacion->publicado_mail() .'</td>
                    </tr>
                    <tr>
                        <th>Titulo Peticion</th>
                        <td>'. $participacion->getTitulo() .'</td>
                    </tr>
                    <tr>
                        <th>Descripcion</th>
                        <td>'. $participacion->getMensaje() .'</td>
                    </tr>
                    <tr>
                        <th>Institucion</th>
                        <td>'.$participacion->getServicio()->getNombre().'</td>
                    </tr>
                    <tr>
                        <th>Fecha de Creacion</th>
                        <td>'. $participacion->getCreatedAt()->format('d/m/Y  H:i') .'</td>
                    </tr>
                    <tr>
                        <th>Votacion</th>
                        <td>'. $participacion->votacion($suscriptionCount) .'</td>
                    </tr>
                </tbody>
            </table>';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participantes->getEmail());
        $this->email->subject('Recordatorio de cambio de solicitud');
        $this->email->message($msg);
        $this->email->send();
        }
        return true;
    }
    /*Funcion para publicar una solicitud en el FrontEnd*/
    public function estadoIngreso($participacionId){
            $participacion = $this->doctrine->em->find('Entities\Participacion',$participacionId);

            $participacion->setPublicado(0);

            $participacion->setUpdatedAt(new DateTime());

            $this->doctrine->em->persist($participacion);
            $this->doctrine->em->flush();           

            $this->addMessage('Se ha publicado la solicitud #'.$participacionId.'.', 'success');

        redirect('backend/participacion');
    }
    /*Funcion para procesar la solicitud*/
    public function solicitudProcesada($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion',$participacionId);

        $participacion->setPublicado(1);
        $participacion->setUpdatedAt(new DateTime());

        $this->procesadaMail($participacionId);
        $this->procesadaSuscritos($participacionId);

        $this->doctrine->em->persist($participacion);
        $this->doctrine->em->flush();    

        $this->addMessage('La solicitud #'.$participacionId.'. se encuentra procesada.', 'success');

        redirect('backend/participacion');
    }
    /*Funcion que envia mail a suscritos, avisando que la publicación se encuentra Procesada*/
     public function procesadaSuscritos($participacionId){
        $suscripcion = $this->doctrine->em->getRepository('Entities\Participacion')->subscriptionMail($participacionId);

        $this->load->library('email');

        $this->loadData('suscripcion', $suscripcion);

        foreach ($suscripcion as $key => $suscritos) {
            $msg = 'Estimado(a),<br>'
            . 'Este mail se le debe enviar a las personas que esan suscritas avisando que la publicaion ha sido resuelta<br><br>';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($suscritos['email']);
        $this->email->subject('SUSCRITOS, LA PUBLICACION ESTA PROCESADA');
        $this->email->message($msg);
        $this->email->send();
        }
        return true;
    }
    /*Funcion para enviar mail a las personas asociadas al servicio cuando esta se da por Procesada*/
    public function procesadaMail($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $parti = $this->doctrine->em->getRepository('Entities\Participacion')->userMailSend($participacion->getInstitucion());

        $this->load->library('email');
        $this->loadData('parti', $parti);

        foreach ($parti as $key => $participantes) {
            $msg = 'Estimado(a) '.$participacion->getNombre().' ,<br> La solicitud se ha aceptado con éxito y GG.';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participantes->getEmail());
        $this->email->subject('Solicitud de Datos Procesada');
        $this->email->message($msg);
        }
        return $this->email->send();
    }
    /* Función para enviar mail al solicitante que la publicación se encuentra Procesada */
    public function procesadaSolicitante(){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $this->load->library('email');
        $this->loadData('participacion', $participacion);

        $msg = 'Estimado(a) '.$participacion->getNombre().' ,<br> La solicitud se ha aceptado con éxito, gracias por hacer la solicitud.';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participacion->getEmail());
        $this->email->subject('Solicitud de Datos Procesada');
        $this->email->message($msg);
        return $this->email->send(); 
    }
    /* Funcion para procesar la solicitud y rechazarla */
    public function solicitudRechazada($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion',$participacionId);

        $participacion->setPublicado(2);
        $participacion->setUpdatedAt(new DateTime());

        $this->doctrine->em->persist($participacion);
        $this->doctrine->em->flush();    

        $this->noProcesadaMail($participacionId);

        $this->addMessage('La solicitud #'.$participacionId.'. no ha cumplido con los requisitos pasar al estado Procesado.', 'danger');

        redirect('backend/participacion');
    }
    /*Funcion para enviar mail a las personas asociadas al servicio cuando esta se da por NO Procesada*/
    public function noProcesadaMail($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);
        $parti = $this->doctrine->em->getRepository('Entities\Participacion')->userMailSend($participacion->getInstitucion());

        $this->load->library('email');
        $this->loadData('parti', $parti);

        foreach ($parti as $key => $participantes) {
            $msg = 'Estimado(a) '.$participacion->getNombre().' ,<br> La solicitud no cumple con los requisitos';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participantes->getEmail());
        $this->email->subject('Solicitud de Datos RECHAZADA');
        $this->email->message($msg);
        }
        return $this->email->send();
    }
    /*Funcion para dejar almacenado las personas que han ingresado*/
    public function addParticipacionEmail($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion', $participacionId);

        $email_reminder = new Entities\EmailReminder;

        $email_reminder->setIdParticipacion($participacion->getId());
        $email_reminder->setTitulo($participacion->getTitulo());
        $email_reminder->setDescripcion($participacion->getMensaje());
        $email_reminder->setInstitucion($participacion->getInstitucion());

        $email_reminder->setCreatedAt(new DateTime());

        $this->doctrine->em->persist($email_reminder);
        $this->doctrine->em->flush();

        return true;
    }
}