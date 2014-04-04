<div class="cont-widget cont-widget-tags cont-widget-color">
	<div class="widget-header">
		<a href="<?php echo site_url('tags'); ?>">ver todos</a>
		<h2 class="etiquetas">Etiquetas populares</h2>
	</div>
	<div class="widget-content">
		<?php foreach ($tags as $key => $tag){ ?>
			<a data-count="<?php echo $tag['ndatasets']; ?>" href="<?php echo site_url('tags/ver/'.$tag[0]->getId()); ?>" class="label label-info"><?php echo $tag[0]->getNombre(); ?> (<?php echo $tag['ndatasets']; ?>)</a>
		<?php } ?>
	</div>
</div>