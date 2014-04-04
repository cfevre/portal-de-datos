<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST">
	<fieldset>
		<legend><?php echo $page->getId()?'Edición página ['.$page->getId().']':'Nueva página'; ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label for="title">Título</label>
			</div>
			<div class="controls">
				<input type="text" name="title" id="title" class="input-xlarge" value="<?php echo $page->getTitle(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="alias">Alias</label>
			</div>
			<div class="controls">
				<input type="text" name="alias" id="alias" class="input-xlarge" value="<?php echo $page->getAlias(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="restricted">Acceso restringido <i class="icon-question-sign popover-icon" data-content="Este contenido sólo será visible para usuarios que hayan iniciado sesión en el sitio." data-trigger="hover" title="Acceso Restringido"></i></label>
			</div>
			<div class="controls">
				<input type="checkbox" value="1" id="restricted" name="restricted" <?php echo $page->getRestricted()?'checked="checked"':''; ?>>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="content">Contenido</label>
			</div>
			<div class="controls">
				<textarea name="content" id="content" class="redactor-content"><?php echo $page->getContent(); ?></textarea>
			</div>
		</div>
		<div class="form-actions">
			<button class="btn btn-primary">Guardar</button>
			<a class="btn" href="<?php echo site_url('backend/page'); ?>">Cancelar</a>
		</div>
		<input type="hidden" name="id" id="id" value="<?php echo $page->getId(); ?>">
	</fieldset>
</form>