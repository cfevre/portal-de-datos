<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST" id="formNoticia">
	<fieldset>
		<legend><?php echo $noticia->getId()?'Edición Noticia ['.$noticia->getId().']':'Nueva Noticia'; ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label for="titulo">Título</label>
			</div>
			<div class="controls">
				<input type="text" class="input-block-level" name="titulo" id="titulo" value="<?php echo $noticia->getTitulo(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="resumen">Resumen</label>
			</div>
			<div class="controls">
				<textarea name="resumen" id="resumen" class="redactor-content"><?php echo $noticia->getResumen(); ?></textarea>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="contenido">Contenido</label>
			</div>
			<div class="controls">
				<textarea name="contenido" id="contenido" class="redactor-content"><?php echo $noticia->getContenido(); ?></textarea>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="foto">Foto</label>
			</div>
			<div class="controls">
				<div class="row-fluid">
					<div class="span5">
						<input type="text" class="input-medium" data-no-url="true" data-preview-container="cont-foto-noticia" name="foto" id="foto" value="<?php echo $noticia->getFoto(); ?>">
						<div data-folder="noticias" data-target="foto" data-button-text="Subir Foto" class="uploadify-input" id="upload-foto" name="upload-foto"></div>
					</div>
					<div class="span7">
						<div id="cont-foto-noticia">
						<?php if($noticia->getFoto()){ ?>
							<img src="<?php echo base_url('assets/timthumb/timthumb.php?zc=1&w=400&src=uploads/noticias/'.$noticia->getFoto()); ?>" alt="Preview noticia">
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" id="id" name="id" value="<?php echo $noticia->getId(); ?>">
		<div class="form-actions">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<a class="btn" href="<?php echo site_url('backend/noticia'); ?>">Cancelar</a>
		</div>
	</fieldset>
</form>