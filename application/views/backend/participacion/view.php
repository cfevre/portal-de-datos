<ul class="breadcrumb">
  <li><a href="<?php echo site_url('backend/participacion'); ?>">Participaciones</a> <span class="divider">/</span></li>
   <li class="active"><?php echo $participacion->getTitulo(); ?></li>
</ul>
<dl>
	<dt>Nombre</dt>
	<dd><?php echo $participacion->getNombre(); ?></dd>
	<dt>Apellidos</dt>
	<dd><?php echo $participacion->getApellidos(); ?></dd>
	<dt>E-mail</dt>
	<dd><?php echo $participacion->getEmail(); ?></dd>
	<dt>Título</dt>
	<dd><?php echo $participacion->getTitulo(); ?></dd>
	<dt>Mensaje</dt>
	<dd><?php echo $participacion->getMensaje(); ?></dd>
	<dt>Categoría</dt>
	<dd><?php echo $participacion->getCategoria(); ?></dd>
	<dt>Estado</dt>
	<dd id="participacion-<?php echo $participacion->getId(); ?>">
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
	</dd>
</dl>