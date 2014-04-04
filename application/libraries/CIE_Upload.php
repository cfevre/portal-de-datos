<?php
class CIE_Upload extends CI_Upload{

    public function is_allowed_filetype($ignore_mime = TRUE){
        return parent::is_allowed_filetype($ignore_mime);
    }
}

?>
