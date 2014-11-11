<div class="span8">
	<h2 class="page-<?php echo $page->getAlias(); ?>">
		<?php echo $page->getTitle(); ?>
	</h2>
	<?php echo widgetHelper::compartirRedesSociales(); ?>
	<div class="page-content">
		<?php echo $page->getContent(); ?>
	</div>
</div>
<div class="span4 side-bar">
    <?php echo widgetHelper::categoriasConMasDatasets(); ?>
</div>