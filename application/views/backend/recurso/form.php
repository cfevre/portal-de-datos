<form action="" id="form-recurso">
	<div class="messages"></div>
	<div class="control-group">
		<div class="control-label">
			<label for="url">Url</label>
		</div>
		<div class="controls">
			<input type="text" class="input-xlarge pull-left" name="url" id="url" value="<?php echo $recurso->getUrl(); ?>">
			<div data-folder="recursos" data-target="url" data-button-text="Subir recurso" class="uploadify-input popover-icon" id="upload-recurso" name="upload-recurso" data-content="pdf, gif, jpg, png, xls, xlsx, xml, json, csv, txt, doc, docx, kml, kmz, txt, zip, sav, gz, tar, tar.gz" data-trigger="hover" data-original-title="Formatos de Archivo"></div>
           <i ></i>         
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="control-group">
		<div class="control-label">
			<label for="descripcion">Descripción</label>
		</div>
		<div class="controls">
			<textarea name="descripcion" id="descripcion" class="redactor-content" data-redactor-buttons="link"><?php echo $recurso->getDescripcion(); ?></textarea>
		</div>
	</div>
</form>
<div class="modal-footer">
	<?php if($recurso->getId()){ ?>
		<button class="btn btn-primary" data-ajax-form-id="form-recurso" data-ajax-command="update" data-ajax-controller="recurso" data-ajax-params="<?php echo $recurso->getId(); ?>">Guardar</button>
	<?php }else{ ?>
		<button class="btn btn-primary" data-ajax-form-id="form-recurso" data-ajax-command="create" data-ajax-controller="recurso" data-ajax-params="<?php echo $recurso->getDataset()->getId(); ?>">Guardar</button>
	<?php } ?>
</div>