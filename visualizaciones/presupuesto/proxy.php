<?
header('Content-type: text/plain; charset=iso-8859-1');	
echo file_get_contents('./csv/'.$_GET['url']);
?>
