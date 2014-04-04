<div class="page-header">
  <h1>Participaciones <small></small></h1>
</div>
<form action="<?php echo site_url('backend/participacion'); ?>" class="form-filtros form-inline">
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
	<input type="hidden" name="orderdir" id="orderdir" value="<?php echo $orderdir; ?>">
	<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>">
</form>
<a target="_blank" class="btn btn-success" href="<?php echo current_url().'?excel=1'.($_SERVER['QUERY_STRING']?'&'.$_SERVER['QUERY_STRING']:''); ?>">Exportar a CSV</a>
<hr>
<?php echo $pagination; ?>
<table class="table table-striped table-sort" data-offset="<?php echo $offset; ?>" data-order-field="<?php echo $orderby; ?>" data-order-dir="<?php echo $orderdir; ?>">
	<thead>
		<tr>
			<th>
				<a href="#" data-order-field="id">#</a>
			</th>
			<th>
				<a href="#" data-order-field="titulo">Título</a>
			</th>
			<th>
				<a href="#" data-order-field="titulo">Nombre</a>
			</th>
			<th>
				<a href="#" data-order-field="publicado">Publicado</a>
			</th>
			<th>
				<a href="#" data-order-field="updated_at">Última Modificación</a>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($participaciones): ?>
			<?php foreach ($participaciones as $key => $participacion){ ?>
				<tr id="participacion-<?php echo $participacion->getId(); ?>">
					<td><?php echo $participacion->getId(); ?></td>
					<td><a href="<?php echo site_url('backend/participacion/view/'.$participacion->getId()); ?>"><?php echo $participacion->getTitulo(); ?></a></td>
					<td><?php echo $participacion->getNombre(); ?> <?php echo $participacion->getApellidos(); ?></td>
					<td>
						<?php if(!$participacion->getPublicado()){ ?>
							<button data-ajax-command="togglePublicado" data-ajax-controller="participacion" data-ajax-params="?id=<?php echo $participacion->getId(); ?>" class="btn btn-mini btn-warning">
								<i class="icon-ban-circle"></i>
								<span>No Publicado</span>
							</button>
						<?php }else{ ?>
							<button data-ajax-command="togglePublicado" data-ajax-controller="participacion" data-ajax-params="?id=<?php echo $participacion->getId(); ?>" class="btn btn-mini btn-success">
								<i class="icon-ok-circle"></i>
								<span>Publicado</span>
							</button>
						<?php } ?>
					</td>
					<td><?php echo $participacion->getUpdatedAt()->format('d/m/Y H:i'); ?></td>
				</tr>
			<?php } ?>
		<?php else: ?>
			<tr>
				<th style="text-align:center" colspan="5">No se han encontrado publicaciones</th>
			</tr>			
		<?php endif ?>
	</tbody>
</table>
<?php echo $pagination; ?>
