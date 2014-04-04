<div class="page-header">
  <a href="<?php echo site_url('backend/dataset/add'); ?>" class="pull-right btn btn-success">Nuevo Dataset</a>
  <h3>Últimos Datasets</h3>
</div>
<div class="cont-datasets">
	<ul class="nav nav-pills nav-stacked">
		<?php if ($datasets): ?>
			<?php foreach ($datasets as $key => $dataset) { ?>
				<li>
					<a href="<?php echo site_url('backend/dataset/view/'.$dataset->getDatasetMaestro()->getId()); ?>"><?php echo $dataset->getTitulo(); ?></a>
				</li>
			<?php } ?>
		<?php else: ?>
			<li><strong>No se han encontrado datasets publicados.</strong></li>
		<?php endif ?>
	</ul>
</div>
