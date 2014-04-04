<ul class="nav nav-list">
	<?php
	foreach ($nav->getPublishedItems() as $key => $item){
		echo navHelper::getItemNavTree('side-menu', $item, $navItem, 0);
	}
	?>
</ul>