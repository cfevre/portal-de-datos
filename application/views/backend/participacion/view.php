<!--<ul class="breadcrumb">
  <li><a href="<?php //echo site_url('backend/participacion'); ?>">Participaciones</a> <span class="divider">/</span></li>
   <li class="active"><?php //echo $participacion->getTitulo(); ?></li>
</ul> -->
<legend>Solicitud de Datos: # <?php echo $participacion->getId(); ?> <?php echo $participacion->getTitulo(); ?></legend>
<table class="table table-striped table-hover">
		<tbody>
		<h4>Datos Personales</h4>
			<tr>
				<th width="150">Estado</th>
				<td><?php echo $participacion->publicado_ver(); ?></td>
			</tr>
			<tr>
				<th>Nombre y Apellido</th>
				<td><?php echo $participacion->getNombre(); ?>  <?php echo $participacion->getApellidos(); ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $participacion->getEmail(); ?></td>
			</tr>
			<tr>
				<th>Edad</th>
				<td><?php echo $participacion->getEdad(); ?></td>
			</tr>
			<tr>
				<th>Región</th>
				<?php echo $participacion->regiones_backend($participacion->getRegion(),2); ?>
			</tr>
			<tr>
				<th>Ocupación</th>
				<td><?php echo $participacion->getOcupacion(); ?></td>
			</tr>
			<tr>
	            <th>Categorías</th>
	            <td>
	                <?php
	                    foreach ($participacion->getCategorias() as $key => $categoria){
	                        $a_categorias[] = $categoria->getNombre();
	                    }
	                    echo isset($a_categorias)?implode(', ', $a_categorias):'No hay categorías asociadas al Dataset';
	                ?>
	            </td>
       		</tr>
		</tbody>
</table>
<table class="table table-striped table-hover">
	<tbody>
		<h4>Datos Dataset</h4>
			<tr>
				<th width="150">Titulo</th>
				<td><?php echo $participacion->getTitulo(); ?></td>
			</tr>
			<tr>
				<th>Descripción</th>
				<td><?php echo $participacion->getMensaje(); ?></td>
			</tr>
			<tr>
				<th>Institución</th>
				<?php $td=''; ?>
				<?php foreach ($entidades as $key => $entidad) { ?>
					<?php if ($entidad->getCodigo() == $participacion->getInstitucion()) { ?>
						<td><?php echo $entidad->getNombre(); ?></td>
						<?php break; ?>
					<?php }else {?>
						<?php $td =null; ?>
					<?php } ?>
				<?php } ?>
				<?php if ($td == null) { ?>
					<td></td>
				<?php } ?>
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
					<?php foreach ($suscripcion as $key => $subscription) { ?>
						<td><?php echo $subscription[1]; ?></td>
					<?php } ?>
			</tr>
			
			<?php if ($participacion->getPublicado() == 1) { ?>
			<tr>
				<th>Enlace</th>
				<td><?php echo $participacion->getEnlace(); ?></td>
			</tr>
			<?php } ?>	
	</tbody>
</table>