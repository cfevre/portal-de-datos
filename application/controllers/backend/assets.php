<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends CIE_Controller {

	function __construct(){

		parent::__construct();
		
	}
	
	public function index() {
		$this->renderView('backend/layout');
	}

	public function upload(){
 
		// files storage folder
		$dir = './uploads/paginas/';
		 
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
		 
		if ($_FILES['file']['type'] == 'image/png' 
		|| $_FILES['file']['type'] == 'image/jpg' 
		|| $_FILES['file']['type'] == 'image/gif' 
		|| $_FILES['file']['type'] == 'image/jpeg'
		|| $_FILES['file']['type'] == 'image/pjpeg'){	
		    // setting file's mysterious name
		    $file = $dir.md5(date('YmdHis')).'.jpg';
		 
		    // copying
		    copy($_FILES['file']['tmp_name'], $file);
		 
		    // displaying file
		    $array = array(
		        'filelink' => base_url().$file
		    );
			
		    echo stripslashes(json_encode($array));   
		}
 	}

 	public function imagesJson(){
		$imagetypes = array("image/jpeg", "image/gif", "image/jpg", "image/png", "image/pjpeg");

 		// array to hold return value
    $retval = array();

    // full server path to directory
    $fulldir = "./uploads/paginas/";

    $d = @dir($fulldir) or die("getImages: Failed opening directory $fulldir for reading");
    while(false !== ($entry = $d->read())) {
      // skip hidden files
      if($entry[0] == ".") continue;

      // check for image files
      $f = escapeshellarg("$fulldir$entry");
      $mimetype = trim(`file -bi $f`);
      foreach($imagetypes as $valid_type) {
        if(preg_match("@^{$valid_type}@", $mimetype)) {
          $retval[] = array(
           'thumb' => "/$fulldir$entry",
           'image' => "/$fulldir$entry"
          );
          break;
        }
      }
    }
    $d->close();

    echo stripslashes(json_encode($retval));
 	}
}
