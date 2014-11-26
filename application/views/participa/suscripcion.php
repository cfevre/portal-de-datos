<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Suscribirse a la Solicitud de Datos</h3>
</div>
<div class="modal-body">
	<table class="table table-striped">
		<tbody>
			<tr>
				<th width="120">Estado</th>
				<td><?php echo $participacion->getId(); ?></td>
			</tr>
		</tbody>
	</table>
	<h3>Para la suscripción a la solicitud ingresar tu mail:</h3>
	<input type="text" placeholder="Type something…" id="email" name="email">
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <a href="" class="btn btn-primary" data-ajax-command="cambiarEstado" data-ajax-controller="participacion" data-ajax-params="<?php echo $participacion->getId(); ?>/0">Aceptar</a>
  </div>
