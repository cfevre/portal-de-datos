<div class="page-header">
  <h1>Aplicaciones <small></small></h1>
</div>
<form action="<?php echo site_url('backend/aplicacion'); ?>" class="form-filtros form-inline">
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
	<input type="hidden" name="orderdir" id="orderdir" value="<?php echo $orderdir; ?>">
	<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>">
</form>
<a href="<?php echo site_url('backend/aplicacion/add'); ?>" class="btn btn-primary">Nueva Aplicación</a>
<hr>
<?php echo $pagination; ?>
<table class="table table-striped table-sort" data-offset="<?php echo $offset; ?>" data-order-field="<?php echo $orderby; ?>" data-order-dir="<?php echo $orderdir; ?>">
	<thead>
		<tr>
			<th>
				<a href="#" data-order-field="id">#</a>
			</th>
			<th>
				<a href="#" data-order-field="nombre">Nombre</a>
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
		<?php if ($aplicaciones): ?>
			<?php foreach ($aplicaciones as $key => $aplicacion){ ?>
				<tr id="aplicacion-<?php echo $aplicacion->getId(); ?>">
					<td><?php echo $aplicacion->getId(); ?></td>
					<td><a href="<?php echo site_url('backend/aplicacion/edit/'.$aplicacion->getId()); ?>"><?php echo $aplicacion->getNombre(); ?></a></td>
					<td>
						<?php if(!$aplicacion->getPublicado()){ ?>
							<button data-ajax-command="togglePublicado" data-ajax-controller="aplicacion" data-ajax-params="?id=<?php echo $aplicacion->getId(); ?>" class="btn btn-mini btn-warning">
								<i class="icon-ban-circle"></i>
								<span>No Publicado</span>
							</button>
						<?php }else{ ?>
							<button data-ajax-command="togglePublicado" data-ajax-controller="aplicacion" data-ajax-params="?id=<?php echo $aplicacion->getId(); ?>" class="btn btn-mini btn-success">
								<i class="icon-ok-circle"></i>
								<span>Publicado</span>
							</button>
						<?php } ?>
					</td>
					<td><?php echo $aplicacion->getUpdatedAt()->format('d/m/Y H:i'); ?></td>
				</tr>	
			<?php } ?>
		<?php else: ?>
			<tr>
				<th style="text-align:center" colspan="4">No se han encontrado Aplicaciones.</th>
			</tr>			
		<?php endif ?>
	</tbody>
</table>
<?php echo $pagination; ?>