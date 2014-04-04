<div class="cont-widget">
	<div class="page-header">
	  <a href="<?php echo site_url('backend/dataset/add'); ?>" class="pull-right btn btn-success">Nuevo Dataset</a>
	  <h3>Últimos Datasets</h3>
	</div>
	<div class="cont-datasets">
		<ul class="nav nav-pills nav-stacked">
			<?php foreach ($datasets as $key => $dataset) { ?>
				<li>
					<a href="<?php echo site_url('backend/dataset/view/'.$dataset->getDatasetMaestro()->getId()); ?>"><?php echo $dataset->getTitulo(); ?></a>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>