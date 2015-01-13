<!--<ul class="breadcrumb">
  <li><a href="<?php //echo site_url('backend/participacion'); ?>">Participaciones</a> <span class="divider">/</span></li>
   <li class="active"><?php //echo $participacion->getTitulo(); ?></li>
</ul> -->
<?php if ($user->hasRol('publicacion') && $user->hasRol('ingreso') 
          && $user->hasRol('mantencion') && $user->hasRol('cms') 
          && $participacion->getPublicado()==3): ?>
	<div class="alert-ingreso alert-success div-alert span4 offset7" style="padding: 8px 35px 8px 14px;
	text-align: right;">
 	Cambiar estado <a class="btn btn-success "href="<?php echo site_url('backend/participacion/estadoIngreso/'.$participacion->getId());?>"><i class=" icon-ok icon-white"></i></a>
</div>
<?php endif ?>
<?php /* 
	$data = file_get_contents ('https://apis.modernizacion.cl/instituciones/api/instituciones');
	$json = json_decode($data, TRUE);

	echo ('<br/> print the json <br/>');
    //print_r ($json);
    echo ('</pre>');

    echo '<br>output:</br>';

    foreach ($json['items'] as $key => $value)
    {	
    	print_r($key.' '.$value['nombre']);
    	//var_dump($value['nombre']);
    	echo '<br>';
	}*/
 ?>
<legend>Solicitud de Datos: # <?php echo $participacion->getId(); ?> <?php echo $participacion->getTitulo(); ?></legend>
<table class="table table-striped table-hover">
		<tbody>
		<h4>Datos Personales</h4>
			<tr>
				<th width="150">Estado</th>
				<td><?php echo $participacion->publicado_ver(1); ?></td>
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
				<td><?php echo $participacion->regiones_backend($participacion->getRegion(),2); ?></td> 
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
				<td> <?php if ($participacion->getServicio()) {
						echo $participacion->getServicio()->getNombre();
						}?>
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
				<td>
					<?php echo $participacion->votacion($suscripcion); ?>
				</td>
			</tr>
			
			<?php if ($participacion->getPublicado() == 1) { ?>
			<tr>
				<th>Enlace</th>
				<td><?php echo $participacion->getEnlace(); ?></td>
			</tr>
			<?php } ?>	
	</tbody>
</table>