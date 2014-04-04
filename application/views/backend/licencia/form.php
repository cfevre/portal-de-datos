<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST" id="formLicencia">
	<fieldset>
		<legend><?php echo $licencia->getId()?'Edición Licencia ['.$licencia->getId().']':'Nueva Licencia'; ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label for="nombre">Nombre</label>
			</div>
			<div class="controls">
				<input type="text" class="input-block-level" name="nombre" id="nombre" value="<?php echo $licencia->getNombre(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="url">Url</label>
			</div>
			<div class="controls">
				<input type="text" class="input-block-level" name="url" id="url" value="<?php echo $licencia->getUrl(); ?>">
			</div>
		</div>
		<input type="hidden" id="id" name="id" value="<?php echo $licencia->getId(); ?>">
		<div class="form-actions">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<a class="btn" href="<?php echo site_url('backend/licencia'); ?>">Cancelar</a>
		</div>
	</fieldset>
</form>