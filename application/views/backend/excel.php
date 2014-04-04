<?php 
    header("Content-type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=".$filename.".csv");
    echo $blocks['content'];
?>