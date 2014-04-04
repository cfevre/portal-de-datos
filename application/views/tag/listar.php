<div class="span8">
	<h3>Tags</h3>
	<?php foreach ($tags as $key => $tag){ ?>
		<a href="<?php echo site_url('tags/ver/'.$tag[0]->getId()); ?>" class="label label-info"><?php echo $tag[0]->getNombre(); ?> (<?php echo $tag['ndatasets']; ?>)</a>
	<?php } ?>
</div>
<div class="span4 side-bar">
    <?php echo widgetHelper::categoriasConMasDatasets(); ?>
    <?php echo widgetHelper::catalogosMasDescargados(10); ?>
</div>