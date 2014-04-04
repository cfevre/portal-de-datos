<h3><?php echo $nav->getTitle(); ?></h3>
<ul class="nav menu-<?php echo $nav->getPosition(); ?>">
	<?php
	foreach ($nav->getPublishedItems() as $key => $item){
		echo navHelper::getItemNavTree('menu', $item, $navItem, 0);
	}
	?>
</ul>