<div class="page-header">
	  		<h1>Solicitud de Datos</h1>
</div>
<?php foreach ($solicitudPendiente as $key => $solicitud) { ?>
	<?php if ($solicitud[1]==0) { ?>
		<div class="alert alert-success">No tienes solicitudes pendientes</div>
	<?php }else {?>
		<div class="alert alert-error"><strong>Tienes <?php echo $solicitud[1]; ?> solicitudes pendientes</strong></div>
	<?php } ?>
<?php } ?>

<?php echo $pagination; ?>
<table id="tabla-datasets" class="table table-striped table-sort" data-offset="<?php echo $offset; ?>" data-order-field="<?php echo $orderby; ?>" data-order-dir="<?php echo $orderdir; ?>">
	<thead>
		<tr>
			<th>
				<a href="#" data-order-field="id">#</a>
			</th>
			<th>
				<a href="#" data-order-field="titulo">Título</a>
			</th>
			<th>
				<a href="#" data-order-field="nombre">Nombre</a>
			</th>
			<th>
				<a href="#" data-order-field="publicado">Estado</a>
			</th>
			<th>
				<a href="#" data-order-field="updated_at">Última Modificación</a>
			</th>
			<th>
				Acciones
			</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($participaciones): ?>
			<?php foreach ($participaciones as $key => $participacion){ ?>
				
					<tr id="participacion-<?php echo $participacion->getId(); ?>">
						<td><?php echo $participacion->getId(); ?></td>
						<td width="400"><a href="<?php echo site_url('backend/participacion/view/'.$participacion->getId()); ?>"><?php echo $participacion->getTitulo(); ?></a></td>
						<td width="150"><?php echo $participacion->getNombre(); ?> <?php echo $participacion->getApellidos(); ?></td>
						<td><?php echo $participacion->publicado_ver(); ?>
	                    </td>
						<td><?php echo $participacion->getUpdatedAt()->format('d/m/Y H:i'); ?></td>
						<td>
							<a href="<?php echo site_url('backend/participacion/view/'.$participacion->getId()); ?>" class="btn btn-success btn-small"><i class="icon-edit icon-white"></i> Editar</a>
							<a onclick="eliminarSolicitud(<?php echo $participacion->getId(); ?>,'<?php echo site_url('backend/participacion/delete/'.$participacion->getId()); ?>')" class="btn btn-danger btn-small"><i class="icon-remove icon-white"></i> Eliminar</a>
						</td>
					</tr>
			<?php } ?>
		<?php else: ?>
			<tr>
				<th style="text-align:center" colspan="5">No se han encontrado publicaciones</th>
			</tr>			
		<?php endif ?>
	</tbody>
</table>
<a target="_blank" class="btn btn-success" href="<?php echo current_url().'?excel=1'.($_SERVER['QUERY_STRING']?'&'.$_SERVER['QUERY_STRING']:''); ?>">Exportar a CSV</a>
<hr>
<?php echo $pagination; ?>
<div id="modalParticipacion" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">

</div>