<div class="row-fluid">
    <?php echo widgetHelper::reportes(); ?>
</div>
<div class="row-fluid">
<?php if ($user->hasRol('cms')): ?>
	<div class="span6 well">
		<?php echo widgetHelper::ultimasNoticias(10, true); ?>
	</div>
<?php endif ?>
<?php if ($user->hasRol('publicacion') || $user->hasRol('ingreso')): ?>
	<div class="span6 well">
		<?php echo widgetHelper::ultimosDatasets(10, true); ?>
	</div>
<?php endif ?>
</div>