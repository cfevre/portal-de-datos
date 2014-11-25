<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Participación</h3>
</div>
<div class="modal-body">
	<table class="table table-striped">
		<tbody>
			<tr>
				<th width="120">Estado</th>
				<td><?php echo $participacion->publicado_ver(); ?></td>
			</tr>
			<tr>
				<th width="120">Titulo</th>
				<td><?php echo $participacion->getTitulo(); ?></td>
			</tr>
			<tr>
				<th>Mensaje</th>
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
				<th>Categoría</th>
				<td><?php echo $participacion->getCategoria(); ?></td>
			</tr>
			<tr>
				<?php if ($participacion->getPublicado()==1 || $participacion->getPublicado()==2) { ?>
					<th>Fecha Actualización</th>
					<td><?php echo $participacion->getUpdatedAt()->format('d/m/Y  H:i'); ?></td>
				<?php } ?>  
				<?php if($participacion->getPublicado() == 0 ){ ?>
					<th>Fecha Creación</th>
					<td><?php echo $participacion->getCreatedAt()->format('d/m/Y  H:i'); ?></td> 
				<?php } ?>
			</tr>
			<tr>
				<th>Votación</th>
				<td>O Seguimiento de esta publicación</td>
			</tr>
			
			<?php if ($participacion->getPublicado() == 1) { ?>
			<tr>
				<th>Enlace</th>
				<td>Aqui debería ir el enlace donde se encuentra publicado</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="modal-footer">
</div>
