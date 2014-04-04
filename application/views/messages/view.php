<?php
	if($messages){
		$type = '';
		foreach ($messages as $key => $message){
			if($type != $message['type']){
				if($type != ''){
					echo '</div>';
				}
				echo '<div class="alert alert-'.$message["type"].'">';
			}
			echo '<p>'.$message["message"].'</p>';
			$type = $message["type"];
		}
		echo '</div>';
	}
?>