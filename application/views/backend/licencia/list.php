<div class="page-header">
  <h1>Licencias <small></small></h1>
</div>
<a href="<?php echo site_url('backend/licencia/add'); ?>" class="btn btn-primary">Nueva Licencia</a>
<hr>
<table id="tabla-licencias" class="table table-striped">
	<thead>
		<tr>
			<th>
				#
			</th>
			<th>
				Nombre
			</th>
			<th>
				Última Modificación
			</th>
			<th>
				Acciones
			</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($licencias): ?>
			<?php foreach ($licencias as $key => $licencia){ ?>
				<tr id="licencia-<?php echo $licencia->getId(); ?>">
					<td><?php echo $licencia->getId(); ?></td>
					<td><a href="<?php echo site_url('backend/licencia/edit/'.$licencia->getId()); ?>"><?php echo $licencia->getNombre(); ?></a></td>
					<td><?php echo $licencia->getUpdatedAt()->format('d/m/Y H:i'); ?></td>
					<td>
						<button data-id="<?php echo $licencia->getId(); ?>" data-name="<?php echo $licencia->getNombre(); ?>" class="btn btn-small btn-danger delete-licencia"><i class="icon-remove"></i> Eliminar</button>
					</td>
				</tr>	
			<?php } ?>
		<?php else: ?>
			<tr>
				<th style="text-align:center" colspan="4">No se han encontrado Licencias.</th>
			</tr>			
		<?php endif ?>
	</tbody>
</table>