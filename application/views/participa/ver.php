<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Participación</h3>
</div>
<div class="modal-body">
	<table class="table table-striped">
		<tbody>
			<tr>
				<th width="120">Titulo</th>
				<td><?php echo $participacion->getTitulo(); ?></td>
			</tr>
			<tr>
				<th>Nombre Completo</th>
				<td><?php echo $participacion->getNombre(); ?> <?php echo $participacion->getApellidos(); ?></td>
			</tr>
			<tr>
				<th>Fecha</th>
				<td><?php echo $participacion->getCreatedAt()->format('d/m/Y'); ?></td>
			</tr>
			<tr>
				<th>Categoría</th>
				<td><?php echo $participacion->getCategoria(); ?></td>
			</tr>
			<tr>
				<th>Mensaje</th>
				<td><?php echo $participacion->getMensaje(); ?></td>
			</tr>
		</tbody>
	</table>
</div>
<div class="modal-footer">
</div>
