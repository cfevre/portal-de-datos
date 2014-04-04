<?php
	/**
	* 
	*/
	class htmlcontentHelper {
		function prepareContent($content){
			if(!$content)
				return '';
			
			$dom = new domDocument;
			$dom->loadHTML('<?xml encoding="UTF-8">' . $content);
			$images = $dom->getElementsByTagName('img');

			foreach ($images as $image) {
				$src = $image->getAttribute('src');
				$image->setAttribute('src', site_url($src));
			}

			return $dom->saveHTML();
		}
	}
?>