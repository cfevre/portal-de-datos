<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST" id="formDataset">
	<fieldset>
		<legend><?php echo $dataset->getId()?'Edición Dataset ['.$dataset->getTitulo().']':'Nuevo Dataset'; ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label for="titulo">Título <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="titulo" id="titulo" class="input-xlarge" value="<?php echo $dataset->getTitulo(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="descripcion">Descripción <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<textarea name="descripcion" id="descripcion" class="redactor-content" data-redactor-buttons="link"><?php echo $dataset->getDescripcion(); ?></textarea>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="servicio_codigo">Institución <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<select name="servicio_codigo" id="servicio_codigo" class="input-xxlarge">
					<option value="">- Seleccione -</option>
					<?php foreach ($servicios as $key => $servicio){ ?>
						<?php $selected = $servicio == $dataset->getServicio() ? 'selected="selected"':''; ?>
						<option <?php echo $selected; ?> value="<?php echo $servicio->getCodigo(); ?>"><?php echo $servicio->getNombre(); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label class="popover-icon" data-content="Tipo de licencia con que se puede usar este Dataset." data-trigger="hover" data-original-title="Licencia" for="licencia_id">Licencia <i class="icon-exclamation-sign"></i><i class="icon-question-sign"></i></label>
			</div>
			<div class="controls">
				<select name="licencia_id" id="licencia_id" class="input-xxlarge">
					<option value="">- Seleccione -</option>
					<?php foreach ($licencias as $key => $licencia){ ?>
						<?php $selected = $licencia == $dataset->getLicencia() ? 'selected="selected"':''; ?>
						<option <?php echo $selected; ?> value="<?php echo $licencia->getId(); ?>"><?php echo $licencia->getNombre(); ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="categorias">Categorías <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<?php foreach ($categorias as $key => $categoria){ ?>
					<label class="label-categorias" for="categorias[<?php echo $categoria->getNombre(); ?>]">
						<input <?php echo $dataset->hasCategoria($categoria)?'checked="checked"':''; ?> type="checkbox" value="<?php echo $categoria->getId(); ?>" name="categorias[]" id="categorias[<?php echo $categoria->getNombre(); ?>]">
						<?php echo $categoria->getNombre(); ?>
					</label>
				<?php } ?>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="tags" class="popover-icon" data-content="Escribe las etiquetas que mejor representan a este Dataset." data-trigger="hover" data-original-title="Etiquetas" >Etiquetas <i class="icon-question-sign"></i></label>
			</div>
			<div class="controls">
				<ul class="nav nav-pills tag-list">
					<?php if($dataset->getTags()){ ?>
						<?php foreach ($dataset->getTags() as $key => $tag){ ?>
							<li><?php echo $tag->getNombre(); ?></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="frecuencia" class="popover-icon" data-content="Frecuencia con que se actualizan estos datos." data-trigger="hover" data-original-title="Frecuencia" >Frecuencia actualización <i class="icon-question-sign"></i></label>
			</div>
			<div class="controls">
				<select name="frecuencia" id="frecuencia">
					<option value="">- Seleccione -</option>
					<?php $frecuencias = array('Diaria', 'Semanal', 'Mensual', 'Trimestral', 'Semestral', 'Anual'); ?>
					<?php foreach ($frecuencias as $key => $frecuencia){ ?>
						<?php $selected = $dataset->getFrecuencia()==$frecuencia?'selected="selected"':''; ?>
						<option <?php echo $selected; ?> value="<?php echo $frecuencia; ?>"><?php echo $frecuencia; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="sectores" class="popover-icon" data-content="Escribe las etiquetas que mejor representan a este Dataset." data-trigger="hover" data-original-title="Sectores" >Cobertura Geográfica<i class="icon-question-sign"></i></label>
			</div>
			<div class="controls">
				<ul class="nav nav-pills sectores-list">
					<?php if($dataset->getSectores()){ ?>
						<?php foreach ($dataset->getSectores() as $key => $sector){ ?>
							<li><?php echo $sector->getNombre(); ?> (<?php echo $sector->getTipo(); ?>)</li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="cobertura_temporal" class="popover-icon" data-content="Utilice cantidades temporales: Fechas exactas o periodos, meses, años, etc." data-trigger="hover" data-original-title="Cobertura Temporal" >Cobertura Temporal<i class="icon-question-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="cobertura_temporal" id="cobertura_temporal" class="input-xlarge" value="<?php echo $dataset->getCoberturaTemporal(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="granularidad" class="popover-icon" data-content="Nivel de detalle con que se presentan los datos segun el nivel de cobertura del Dataset." data-trigger="hover" data-original-title="Granularidad" >Granularidad<i class="icon-question-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="granularidad" id="granularidad" class="input-xlarge" value="<?php echo $dataset->getGranularidad(); ?>">
			</div>
		</div>
		<?php if ($dataset->getId()): ?>
			<legend>Recursos</legend>
			<div class="hide" id="message-recurso"></div>
			<a href="<?php echo site_url('backend/recurso/add/'.$dataset->getId()); ?>" class="btn btn-small btn-success ajax-modal" data-modal-header="Nuevo Recurso">Nuevo Recurso</a>
			<table class="table" id="tabla-recursos">
				<thead>
					<tr>
						<th>URL</th>
						<th>Descripción</th>
						<th>Tipo</th>
						<th>Tamaño</th>
						<th width="180">Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataset->getRecursos() as $key => $recurso){ ?>
						<tr id="recurso-<?php echo $recurso->getId(); ?>">
							<td><a target="_blank" href="<?php echo $recurso->getUrl(); ?>"><?php echo $recurso->getUrl(); ?></a></td>
							<td><?php echo $recurso->getDescripcion(); ?></td>
							<td><?php echo $recurso->getMime(); ?></td>
							<td><?php echo stringsHelper::getUnitFormat($recurso->getSize()); ?></td>
							<td nowrap>
								<a href="<?php echo site_url('backend/recurso/edit/'.$recurso->getId()); ?>" class="btn btn-small btn-success ajax-modal" data-modal-header="Editar Recurso [<?php echo $recurso->getId(); ?>]"><i class="icon-edit"></i> Editar</a>
								<button data-ajax-command="delete" data-ajax-controller="recurso" data-ajax-params="<?php echo $recurso->getId(); ?>" data-confirm="¿Está seguro que desea eliminar el recurso [<?php echo $recurso->getId(); ?>]?" class="btn btn-small btn-danger"><i class="icon-remove"></i> Eliminar</button>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<legend>Documentos</legend>
			<div class="hide" id="message-documento"></div>
			<a href="<?php echo site_url('backend/documento/add/'.$dataset->getId()); ?>" class="btn btn-small btn-success ajax-modal" data-modal-header="Nuevo Documento">Nuevo Documento</a>
			<table class="table" id="tabla-documentos">
				<thead>
					<tr>
						<th>URL</th>
						<th>Título</th>
						<th>Descripción</th>
						<th>Tipo</th>
						<th>Tamaño</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataset->getDocumentos() as $key => $documento){ ?>
						<tr id="documento-<?php echo $documento->getId(); ?>">
							<td><a target="_blank" href="<?php echo $documento->getUrl(); ?>"><?php echo $documento->getUrl(); ?></a></td>
							<td><?php echo $documento->getTitulo(); ?></td>
							<td><?php echo $documento->getDescripcion(); ?></td>
							<td><?php echo $documento->getMime(); ?></td>
							<td><?php echo $documento->getSize(); ?></td>
							<td nowrap>
								<a href="<?php echo site_url('backend/documento/edit/'.$documento->getId()); ?>" class="btn btn-small btn-success ajax-modal" data-modal-header="Editar Recurso [<?php echo $documento->getId(); ?>]"><i class="icon-edit"></i> Editar</a>
								<button data-ajax-command="delete" data-ajax-controller="documento" data-ajax-params="<?php echo $documento->getId(); ?>" data-confirm="¿Está seguro que desea eliminar el documento [<?php echo $documento->getId(); ?>]?" class="btn btn-small btn-danger"><i class="icon-remove"></i> Eliminar</button>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php else: ?>
			<div class="alert alert-warning">
				<strong>Para poder agregar Recursos y Documentos primero debe grabar el dataset.</strong>
			</div>
		<?php endif ?>
		<div class="form-actions">
			<button class="btn btn-primary">Grabar</button>
		</div>
		<input type="hidden" value="<?php echo $dataset->getId(); ?>" name="id" id="id">
	</fieldset>
</form>