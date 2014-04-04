<div class="cont-widget cont-widget-mas-descargados">
	<div class="widget-header">
		<a href="<?php echo site_url('datasets/listar?orderby=ndescargas'); ?>">ver todos</a>
		<h2 class="catalogo-datos">Datos más descargados <span>(último mes)</span></h2>
	</div>
	<div class="widget-content">
		<ol>
		<?php foreach ($catalogos['masdescargados'] as $key => $dataset){ ?>
			<li>
				<a href="<?php echo site_url('datasets/ver/'.$dataset[0]->getDatasetMaestro()->getId()); ?>">
					<?php echo $dataset[0]->getTitulo(); ?>
				</a>
				<small>(<?php echo $dataset['total_descargas']; ?>)</small>
			</li>
		<?php } ?>
		</ol>
	</div>
</div>