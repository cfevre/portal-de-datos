<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST">
	<fieldset>
		<legend><?php echo $navItem->getId()?'Edición item ['.$navItem->getTitle().']':'Nuevo item del menú ['.$nav->getTitle().']'; ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label for="title">Título</label>
			</div>
			<div class="controls">
				<input type="text" name="title" id="title" class="input-xlarge" value="<?php echo $navItem->getTitle(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="alias">Alias</label>
			</div>
			<div class="controls">
				<input type="text" name="alias" id="alias" class="input-xlarge" value="<?php echo $navItem->getAlias(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="homepage">Página de inicio <i class="icon-question-sign popover-icon" data-content="Marca el item para que se muestr como pagina de inicio." data-trigger="hover" title="Página de Inicio"></i></label>
			</div>
			<div class="controls">
				<input type="checkbox" value="1" id="homepage" name="homepage" <?php echo $navItem->getHomepage()?'checked="checked"':''; ?>>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="ordering">Orden</label>
			</div>
			<div class="controls">
				<input class="input-mini" type="number" id="ordering" name="ordering" value="<?php echo $navItem->getOrdering(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="parentNavItem">Item Padre</label>
			</div>
			<div class="controls">
				<?php echo $navItemList; ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="page_id">Pagina</label>
			</div>
			<div class="controls">
				<?php echo $pagesList; ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="customurl">Url fija <i class="icon-question-sign popover-icon" data-content="Si se ingresa un url fija, se quitará la pagina asociada." data-trigger="hover" title="Url Fija"></i></label>
			</div>
			<div class="controls">
				<input type="text" id="customurl" name="customurl" value="<?php echo $navItem->getCustomurl(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="target">Target</label>
			</div>
			<div class="controls">
				<select name="target" id="target">
					<option value="">- Ignorar -</option>
					<option <?php echo $navItem->getTarget()=='_blank'?'selected="selected"':''; ?> value="_blank">Blank</option>
					<option <?php echo $navItem->getTarget()=='_self'?'selected="selected"':''; ?> value="_self">Self</option>
					<option <?php echo $navItem->getTarget()=='_parent'?'selected="selected"':''; ?> value="_parent">Parent</option>
					<option <?php echo $navItem->getTarget()=='_top'?'selected="selected"':''; ?> value="_top">Top</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="layout">Layout</label>
			</div>
			<div class="controls">
				<?php echo $layoutList; ?>
			</div>
		</div>
		<div class="form-actions">
			<button class="btn btn-primary">Guardar</button>
			<a class="btn" href="<?php echo site_url('backend/nav/edit/'.$nav->getId()); ?>">Cancelar</a>
		</div>
		<input type="hidden" name="id" id="id" value="<?php echo $navItem->getId(); ?>">
		<input type="hidden" name="nav_id" id="nav_id" value="<?php echo $nav->getId(); ?>">
	</fieldset>
</form>