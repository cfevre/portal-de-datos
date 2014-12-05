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
        $this->envia_mail_suscritos($participacionId);

        $this->addMessage('Se ha actualizado la solicitud, #'.$participacionId.'.', 'success');

        redirect('backend/participacion');
    }
    /*---------------------------------------------*/
     /*Cambiar estado de la solicitud*/
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

        $this->doctrine->em->persist($parti);
        $this->doctrine->em->flush();

        $this->envia_mail_solicitudes($participacionId);
        $this->envia_mail_suscritos($participacionId);

        $this->addMessage('Se ha actualizado la solicitud, #'.$participacionId.'.', 'success');

        redirect('backend/participacion');
    }
    /*Actualizar solicitud de datos*/
    public function actualizarSolicitud($participacionId){
        $participacion = $this->doctrine->em->find('Entities\Participacion',$participacionId);
        $categorias = $this->doctrine->em->getRepository('Entities\Categoria')->findBy(array('id' => $this->input->post('categoria', true)));

        $participacion->setNombre($this->input->post('nombre', true));
        $participacion->setApellidos($this->input->post('apellido', true));
        $participacion->setEmail($this->input->post('email', true));

        $participacion->setEdad($this->input->post('edad', true));
        $participacion->setRegion($this->input->post('region', true));
        $participacion->setOcupacion($this->input->post('ocupacion', true));

        $participacion->setTitulo($this->input->post('titulo', true));
        $participacion->setMensaje($this->input->post('mensaje', true));
        $participacion->setInstitucion($this->input->post('servicio_codigo', true));
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
            $msg = 'Estimado(a) '.$participacion->getNombre(). ',<br>'
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
                        <td>'.$participacion->institucion($entidades).'</td>
                    </tr>
                    <tr>
                        <th>Categoria</td>
                        <td>'. $participacion->getCategoria() .'</td>
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
    public function envia_mail_suscritos($participacionId){
        $suscripcion = $this->doctrine->em->getRepository('Entities\Participacion')->subscriptionMail($participacionId);

        $this->load->library('email');

        $this->loadData('suscripcion', $suscripcion);

        foreach ($suscripcion as $key => $suscritos) {
            $msg = 'Estimado(a),<br>'
            . 'Este mail se envia cuando se cambia de solicitud de no procesado a procesado.Y solo se le envia a los suscritos a la solicitud.<br><br>';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($suscritos['email']);
        $this->email->subject('Estas suscrito a la solicitud');
        $this->email->message($msg);
        $this->email->send();
        }
        return true;
    }
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
            $msg = 'Estimado(a) '.$participacion->getNombre(). ',<br>'
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
                        <td>'.$participacion->institucion($entidades).'</td>
                    </tr>
                    <tr>
                        <th>Categoria</td>
                        <td>'. $participacion->getCategoria() .'</td>
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
        }
        return $this->email->send();
    }

    public function estadoIngreso($participacionId){
            $participacion = $this->doctrine->em->find('Entities\Participacion',$participacionId);

            $participacion->setPublicado(0);

            $participacion->setUpdatedAt(new DateTime());

            $this->doctrine->em->persist($participacion);
            $this->doctrine->em->flush();           

            $this->addMessage('Se ha publicado la solicitud #'.$participacionId.'.', 'success');

        redirect('backend/participacion');
    }
    public function procesadaMail($participacionId){
        $parti = $this->doctrine->em->getRepository('Entities\Participacion')->userMailSend($participacion->getInstitucion());

        $this->load->library('email');
        $this->loadData('parti', $parti);

        foreach ($parti as $key => $participantes) {
            $msg = 'Estimado(a) '.$participacion->getNombre(). ',<br>';

        $this->email->from('datosabiertos@minsegpres.gob.cl');
        $this->email->to($participantes->getEmail());
        $this->email->subject('Solicitud de Datos Procesada');
        $this->email->message($msg);
        }
        return $this->email->send();
    }
}