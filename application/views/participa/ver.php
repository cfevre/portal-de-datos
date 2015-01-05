<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Solicitud de Datos: <?php echo $participacion->getTitulo(); ?></h3>
</div>
<div class="modal-body">
	<table class="table table-striped">
		<tbody>
			<tr>
				<th width="120">Estado</th>
				<td><?php echo $participacion->publicado_ver(2); ?></td>
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
				<td> <?php if ($participacion->getServicio()) {
						echo $participacion->getServicio()->getNombre();
						}?>
				</td>
			</tr>
			<tr>
	            <th>Categorías</th>
	            <td>
	                <?php
	                    foreach ($participacion->getCategorias() as $key => $categoria){
	                        $a_categorias[] = $categoria->getNombre();
	                    }
	                    echo isset($a_categorias)?implode(', ', $a_categorias):'No hay categorías asociadas a la solicitud';
	                ?>
	            </td>
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
					<td><?php echo $participacion->votacion($suscripcion); ?></td>
			</tr>		
			<?php if ($participacion->getPublicado() == 1) { ?>
			<tr>
				<th>Enlace</th>
				<td><?php echo $participacion->getEnlace(); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="modal-footer">
</div>
