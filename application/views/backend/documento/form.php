<form action="" id="form-documento">
	<div class="messages"></div>
	<div class="control-group">
		<div class="control-label">
			<label for="titulo">Título</label>
		</div>
		<div class="controls">
			<input type="text" class="input-xlarge" name="titulo" id="titulo" value="<?php echo $documento->getTitulo(); ?>">
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<label for="url">Url</label>
		</div>
		<div class="controls">
			<input type="text" class="input-xlarge pull-left" name="url" id="url" value="<?php echo $documento->getUrl(); ?>">
			<div data-folder="documentos" data-target="url" data-button-text="Subir documento" class="uploadify-input" id="upload-documento" name="upload-documento"></div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="control-group">
		<div class="control-label">
			<label for="descripcion">Descripción</label>
		</div>
		<div class="controls">
			<textarea name="descripcion" id="descripcion" class="redactor-content" data-redactor-buttons="link"><?php echo $documento->getDescripcion(); ?></textarea>
		</div>
	</div>
</form>
<div class="modal-footer">
	<?php if($documento->getId()){ ?>
		<button class="btn btn-primary" data-ajax-form-id="form-documento" data-ajax-command="update" data-ajax-controller="documento" data-ajax-params="<?php echo $documento->getId(); ?>">Guardar</button>
	<?php }else{ ?>
		<button class="btn btn-primary" data-ajax-form-id="form-documento" data-ajax-command="create" data-ajax-controller="documento" data-ajax-params="<?php echo $documento->getDataset()->getId(); ?>">Guardar</button>
	<?php } ?>
</div>