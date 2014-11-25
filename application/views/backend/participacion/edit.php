<form action="<?php echo site_url('backend/participacion/actualizarSolicitud/'.$participacion->getId());?>" method="POST" class="form-horizontal" id="formDataset">
	<fieldset>
		<legend>Editar solicitud de datos: # <?php echo $participacion->getId(); ?> <?php echo $participacion->getTitulo(); ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label class="popover-icon" data-content="Cambiar el estado de la solicitud" data-trigger="hover" data-original-title="Cambiar Estado" for="licencia_id">Cambiar Estado 
					<i class="icon-exclamation-sign"></i>
					<i class="icon-question-sign"></i>
				</label>
			</div>
			<div id="participacion-<?php echo $participacion->getId(); ?>">
				<div class="controls">
				  	<?php echo $participacion->publicado(); ?>
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="nombre">Nombre <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="nombre" id="nombre" class="input-xlarge" value="<?php echo $participacion->getNombre(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="apellido">Apellido <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="apellido" id="apellido" class="input-xlarge" value="<?php echo $participacion->getApellidos(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="email">Email <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="email" name="email" id="email" class="input-xlarge" value="<?php echo $participacion->getEmail(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="edad">Edad <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="edad" id="edad" class="input-xlarge" value="<?php echo $participacion->getEdad(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="region">Región<i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<select name="region" id="region">
					<?php echo $participacion->regiones_backend($participacion->getRegion(),1); ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="ocupacion">Ocupación <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="ocupacion" id="ocupacion" class="input-xlarge" value="<?php echo $participacion->getOcupacion(); ?>">
			</div>
		</div>
		<legend>Editar solicitud de dataset</legend>
		<div class="control-group">
			<div class="control-label">
				<label for="titulo">Título <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="titulo" id="titulo" class="input-xlarge" value="<?php echo $participacion->getTitulo(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="mensaje">Descripción <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<div>
					<textarea class="input-xlarge" name="mensaje" id="mensaje" cols="" rows="8"><?php echo $participacion->getMensaje(); ?></textarea>
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="servicio_codigo">Institución <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<select name="servicio_codigo" id="servicio_codigo" class="input-xxlarge">
					<?php echo widgetHelper::entidadSeleccionada($participacion->getInstitucion()); ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="categoria">Categoría <i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<select name="categoria" id="categoria" class="input-xlarge">
					<?php echo widgetHelper::categoriasSeleccionadas($participacion->getCategoria()); ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="creacion">Fecha Creación<i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="creacion" id="creacion" class="input-xlarge" value="<?php echo $participacion->getCreatedAt()->format('d/m/Y H:i'); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="actualizacion">Fecha Última Actualización<i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="actualizacion" id="actualizacion" class="input-xlarge" value="<?php echo $participacion->getUpdatedAt()->format('d/m/Y H:i'); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="votacion">Votación<i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="votacion" id="votacion" class="input-xlarge" value="">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="enlace">Enlace<i class="icon-exclamation-sign"></i></label>
			</div>
			<div class="controls">
				<input type="text" name="enlace" id="enlace" class="input-xlarge" value="<?php echo $participacion->getEnlace(); ?>">
			</div>
		</div>
		<div class="form-actions">
			<button class="btn btn-primary" type="submit">Guardar</button>
		</div>
	</fieldset>
</form>
<!-- Modal -->
<div id="Procesado" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Cambiar Estado de Solicitud</h3>
  </div>
  <div class="modal-body">
    <p>Aqui podría ir un texto informando que al cambiar de solicitud se enviará un correo a toda la gente que este asociada a la solicitud</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <a href="" class="btn btn-primary" data-ajax-command="cambiarEstado" data-ajax-controller="participacion" data-ajax-params="<?php echo $participacion->getId(); ?>/1">Aceptar</a>
  </div>
</div>
<!-- Modal -->
<div id="EnProceso" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Cambiar Estado de Solicitud</h3>
  </div>
  <div class="modal-body">
  <p>Aqui va a el texto que le indica a la persona que se le va a cambiar desde le estado no procesado a en proceso</p>
    <table class="table table-striped table-hover">
		<tbody>
			<tr>
				<th width="150">Estado</th>
				<td><?php echo $participacion->publicado_ver(); ?></td>
			</tr>
			<tr>
				<th>Título Petición</th>
				<td><?php echo $participacion->getTitulo(); ?></td>
			</tr>
			<tr>
				<th>Descripción</th>
				<td><?php echo $participacion->getMensaje(); ?></td>
			</tr>
			<tr>
				<th>Institución</th>
				<?php foreach ($entidades as $key => $entidad) { ?>
					<?php if ($entidad->getCodigo() == $participacion->getInstitucion()) { ?>
						<td><?php echo $entidad->getNombre(); ?></td>
					<?php }?>
				<?php } ?>
			</tr>
			<tr>
				<th>Categoría</td>
				<td><?php echo $participacion->getCategoria(); ?></td>
			</tr>
			<tr>
				<th>Fecha de Creación</th>
				<td><?php echo $participacion->getCreatedAt()->format('d/m/Y  H:i'); ?></td>
			</tr>
			<tr>
				<th>Votación</th>
				<td>*Aqui va a ir la votación*</td>
			</tr>
		</tbody>
</table>
<p>Se enviará un mail informando sobre el cambio a las personas asociadas a la institucion de la solicitud</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <a href="" class="btn btn-primary" data-ajax-command="cambiarEstado" data-ajax-controller="participacion" data-ajax-params="<?php echo $participacion->getId(); ?>/2">Aceptar</a>
  </div>
</div>
<!-- Modal -->
<div id="NoProcesado" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Cambiar Estado de Solicitud</h3>
  </div>
  <div class="modal-body">
    <p>Aqui podría ir un texto informando que al cambiar de solicitud se enviará un correo a toda la gente que este asociada a la solicitud</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <a href="" class="btn btn-primary" data-ajax-command="cambiarEstado" data-ajax-controller="participacion" data-ajax-params="<?php echo $participacion->getId(); ?>/0">Aceptar</a>
  </div>
</div>