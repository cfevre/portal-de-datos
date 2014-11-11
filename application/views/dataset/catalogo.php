<div class="span8">
	<h2 class="catalogo">Catálogo de Datos <small>&nbsp;Datasets publicados: <strong><?php echo number_format($ndatasets,0,',','.'); ?></strong></small></h2>
	<div>
		<?php echo widgetHelper::catalogosPorEntidad(); ?>
	</div>
</div>
<div class="span4 side-bar">
    <?php echo widgetHelper::categoriasConMasDatasets(); ?> 
    <?php echo widgetHelper::catalogosMasDescargados(); ?>
</div>