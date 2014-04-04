<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST" id="formAplicacion">
	<fieldset>
		<legend><?php echo $aplicacion->getId()?'Edición Aplicacion ['.$aplicacion->getId().']':'Nueva Aplicacion'; ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label for="nombre">Nombre</label>
			</div>
			<div class="controls">
				<input type="text" class="input-block-level" name="nombre" id="nombre" value="<?php echo $aplicacion->getNombre(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="autor">Autor</label>
			</div>
			<div class="controls">
				<input type="text" class="input-block-level" name="autor" id="autor" value="<?php echo $aplicacion->getAutor(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="url">Url</label>
			</div>
			<div class="controls">
				<input type="text" class="input-block-level" name="url" id="url" value="<?php echo $aplicacion->getUrl(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="acceso">Acceso</label>
			</div>
			<div class="controls">
				<select  class="input-medium" name="acceso" id="acceso">
					<option value="publica"<?php echo $aplicacion->getAcceso()=='publica'?' selected="selected"':''; ?>>Pública</option>
					<option value="privada"<?php echo $aplicacion->getAcceso()=='privada'?' selected="selected"':''; ?>>Privada</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="plataforma">Plataforma</label>
			</div>
			<div class="controls">
				<select  class="input-medium" name="plataforma" id="plataforma">
					<option value="web"<?php echo $aplicacion->getPlataforma()=='web'?' selected="selected"':''; ?>>Web</option>
					<option value="movil"<?php echo $aplicacion->getPlataforma()=='movil'?' selected="selected"':''; ?>>Móvil</option>
				</select>
			</div>
		</div>	<div class="control-group">
			<div class="control-label">
				<label for="descripcion">Descripción</label>
			</div>
			<div class="controls">
				<textarea name="descripcion" id="descripcion" class="redactor-content" data-redactor-buttons="link,|,bold,italic,deleted"><?php echo $aplicacion->getDescripcion(); ?></textarea>
			</div>
		</div>
		<input type="hidden" id="id" name="id" value="<?php echo $aplicacion->getId(); ?>">
		<div class="form-actions">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<a class="btn" href="<?php echo site_url('backend/aplicacion'); ?>">Cancelar</a>
		</div>
	</fieldset>
</form>