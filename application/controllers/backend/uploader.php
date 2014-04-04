<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploader extends CIE_Controller {

	public function __construct(){
		$this->sectionRols = array('publicacion||ingreso||mantencion||cms');
		parent::__construct();
	}

	public function upload($folder){
	
		$this->load->library('qqFileUploader');

		$filename = $this->input->get('qqfile', true);
		$path = FCPATH.'uploads/'.$folder.'/';

		$allowedExtensions = array('pdf','gif','jpg','png','xls','xlsx','xml','json','csv','txt','doc','docx','kml','kmz','txt','zip','sav','gz','tar','tar.gz');

		$uploader = new qqFileUploader($allowedExtensions);

		$result = $uploader->handleUpload($path);
        $result['filename'] = $uploader->getUploadName();

		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

	}
}