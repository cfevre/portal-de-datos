<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aplicaciones extends CIE_Controller {

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load->library('pagination');

        $limit = 8;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'created_at';
        $filterby = $this->input->get('filterby') ? $this->input->get('filterby') : null;

        if($orderby == 'titulo'){
            $orderdir = 'ASC';
        }else{
            $orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';
        }

        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'aplicaciones'));

        $total = $this->doctrine->em->getRepository('Entities\Aplicacion')->findWithOrdering(array('total' => true, 'filterby' => $filterby), array($orderby => $orderdir), $limit, $offset);
        $aplicaciones = $this->doctrine->em->getRepository('Entities\Aplicacion')->findWithOrdering(array('filterby' => $filterby), array($orderby => $orderdir), $limit, $offset);

        $pagination_config['base_url'] = site_url('aplicaciones?orderby='.$orderby.'&orderdir='.$orderdir);
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $limit;

        $this->pagination->initialize($pagination_config);
      
        $this->loadData('orderby', $orderby);
        $this->loadData('offset', $offset);
        $this->loadData('filterby', $filterby);
        $this->loadData('limit', $limit);
        $this->loadData('total', $total);
        $this->loadData('pagination', $this->pagination->create_links());

        $this->loadData('navItem', $navItem);
        $this->loadData('aplicaciones', $aplicaciones);

        $this->setPageTitle('Aplicaciones');

        $this->loadNavs();
        $this->loadBreadcrumb($this->data);
        $this->loadBlock('content', 'aplicacion/listar', $this->data);
        
        $this->loadScript('masonry', site_url('assets/js/libs/jquery.masonry.min.js'));

        $this->renderView('layout');
    }

    public function ver($aplicacionId){
        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('alias'=>'aplicaciones'));
        $aplicacion = $this->doctrine->em->getRepository('Entities\Aplicacion')->find($aplicacionId);
        
        $this->loadData('navItem', $navItem);
        $this->loadData('aplicacion', $aplicacion);

        $extra_crumbs[] = array('link' => '', 'title' => $aplicacion->getTitulo());

        $this->loadNavs();
        $this->loadBreadcrumb($this->data, $extra_crumbs);
        $this->loadBlock('content', 'aplicacion/ver', $this->data);

        $this->renderView('layout');
    }

    public function rss($limit = 4) {
        $aplicaciones = $this->doctrine->em->getRepository('Entities\Aplicacion')->findWithOrdering(null, array('created_at' => 'DESC'), $limit);
        $this->loadData('aplicaciones', $aplicaciones);

        header("Content-Type: application/xml; charset=UTF-8");
        $this->load->view('aplicacion/rss', $this->data);
    }

}
