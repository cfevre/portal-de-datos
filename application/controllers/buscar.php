<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buscar extends CIE_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->dataset();
    }

    public function dataset(){
        $this->load->library('sphinxclient');
        $q = $this->input->get('q', true);

        $this->load->library('pagination');

        $limit = 10;
        $offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
        $orderby = $this->input->get('orderby') ? $this->input->get('orderby') : NULL;
        $orderdir = $this->input->get('orderdir') ? $this->input->get('orderdir') : 'DESC';

        if($orderby == 'titulo')
            $orderdir = 'ASC';

        $search_result = $this->doctrine->em->getRepository('Entities\Dataset')->search($q, null, array($orderby => $orderdir), $limit, $offset);
        $datasets = $search_result['datasets'];
        $total = $search_result['total'];
        //$total = $this->doctrine->em->getRepository('Entities\Dataset')->search($q, array('total' => true), array($orderby => $orderdir), $limit, $offset);

        $navItem = $this->doctrine->em->getRepository('Entities\NavItem')->findOneBy(array('customurl'=>'datasets'));

        $pagination_config['base_url'] = base_url().'buscar/?q='.$q.'&orderby='.$orderby.'&orderdir='.$orderdir;
        $pagination_config['total_rows'] = $total;
        $pagination_config['per_page'] = $limit;

        $this->pagination->initialize($pagination_config);

        $this->loadData('q', $q);
        $this->loadData('navItem', $navItem);
        $this->loadData('search_string', $q);
        $this->loadData('datasets', $datasets);
        $this->loadData('orderby', $orderby);
        $this->loadData('offset', $offset);
        $this->loadData('limit', $limit);
        $this->loadData('total', $total);
        $this->loadData('pagination', $this->pagination->create_links());
        $this->loadData('list_title', 'Busqueda');

        $this->setPageTitle('Busqueda - '.$q);

        $this->loadNavs();

        $this->loadBreadcrumb($this->data);

        $this->loadBlock('content', 'dataset/listar', $this->data);

        $this->renderView('layout');

    }

}

?>