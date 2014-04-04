<?php
	class mimeHelper{
		/**
		 * List of Mime Types
		 *
		 * This is a list of mime types.  We use it to validate
		 * the "allowed types" set by the developer
		 *
		 * @param	string
		 * @return	string
		 */
		public function get_mimes_types(){
				if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/mimes.php')){
					include(APPPATH.'config/'.ENVIRONMENT.'/mimes.php');
				} elseif (is_file(APPPATH.'config/mimes.php')){
					include(APPPATH.'config//mimes.php');
				} else{
					return FALSE;
				}
			return $mimes;
		}

		function get_mime_name($type = '') {
			$mimes = mimeHelper::get_mimes_types();
			foreach ($mimes as $nombre => $mime) {
				if(gettype($mime) == 'string'){
					if($mime == $type)
						return $nombre;
				}else{
					foreach ($mime as $key => $sub_mime) {
						if($sub_mime == $type)
							return $nombre;
					}
				}
			}
			return 'html';
		}
	}
?>