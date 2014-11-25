<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap.min.css') ?>">
    <style type="text/css">
      body { padding-top: 60px; padding-bottom: 40px; }
      .sidebar-nav { padding: 9px 0; }
    </style>
    <link href="<?php echo site_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/backend.css'); ?>">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">
    <?php foreach ($stylesheets as $key => $stylesheet){ ?>
   		<link rel="stylesheet" href="<?php echo $stylesheet; ?>" />
    <?php } ?>
    <script src="<?php echo base_url('assets/js/libs/modernizr-2.5.3.min.js') ?>"></script>
  </head>

  <body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="<?php echo site_url('backend'); ?>">Backend Datos.gob.cl</a>
					<div class="brand loged-user">
						Bienvenido <?php echo $data['user']->getFullName(); ?>
						-
						<a class="label label-info" href="<?php echo site_url('backend/user/edit/'.$user->getId()); ?>"><i class="icon-user icon-white"></i> Mi Cuenta</a>
						-
						<a class="label label-important" href="<?php echo site_url('auth/logout'); ?>"><i class="icon-off icon-white"></i> Salir</a>
					</div>
				</div>
			</div>
		</div>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
						<ul class="nav nav-list">
							<?php if($user->hasRol('mantencion')){ ?>
								<li class="nav-header">Mantención</li>
								<li><a href="<?php echo site_url('backend/user'); ?>">Usuarios</a></li>
								<li><a href="<?php echo site_url('backend/nav'); ?>">Menús</a></li>
								<li><a href="<?php echo site_url('backend/licencia'); ?>">Licencias</a></li>
                                <li><a href="<?php echo site_url('backend/reporte'); ?>">Reportes</a></li>
                                <li><a href="<?php echo site_url('backend/tiporeporte'); ?>">Tipos de Reporte</a></li>
							<?php } ?>
              <?php if ($user->hasRol('publicacion') || $user->hasRol('ingreso')): ?>
                <li class="nav-header">Solicitudes</li>
                <li><a href="<?php echo site_url('backend/participacion'); ?>">Solicita Datos</a></li>
              <?php endif ?>
							<?php if ($user->hasRol('cms')): ?>
								<li class="nav-header">Contenido</li>	
								<li><a href="<?php echo site_url('backend/page'); ?>">Páginas</a></li>
								<li><a href="<?php echo site_url('backend/noticia'); ?>">Noticias</a></li>
								<li><a href="<?php echo site_url('backend/aplicacion'); ?>">Aplicaciones</a></li>
                <li><a href="<?php echo site_url('backend/visualizacion'); ?>">Visualizaciones</a></li>
							<?php endif ?>
							<?php if ($user->hasRol('publicacion') || $user->hasRol('ingreso')): ?>
								<li class="nav-header">Datasets</li>
								<li><a href="<?php echo site_url('backend/dataset'); ?>">Datasets</a></li>
                                <li><a href="<?php echo site_url('backend/servicio'); ?>">Servicios</a></li>
							<?php endif ?>
						</ul>
          </div>
        </div>
        <div class="span10">
            <?php echo $blocks['messages']; ?>
	        <div class="row-fluid">
    			    <?php echo isset($blocks['content-navbar'])?$blocks['content-navbar']:''; ?>
    		      <?php echo $blocks['content']; ?>
	        </div>
        </div>
      </div>

      <hr>

      <footer>
          <p>Copyleft Modernización y Gobierno Electrónico 2012</p>
      </footer>

    </div>
    <script type="text/javascript" src="<?php echo site_url('assets/js/libs/jquery-1.8.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/libs/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/libs/bootstrap.overrides.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/libs/bootstrap.tagit.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/backend.js'); ?>"></script>
    <?php foreach ($scripts as $key => $script){ ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script>
    <?php } ?>
    <input type="hidden" value="<?php echo base_url('backend'); ?>" id="admin_url" name="admin_url">
    <input type="hidden" value="<?php echo base_url(); ?>" id="base_url" name="base_url">
    <div class="modal hide fade" id="modal-backend">
    	<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3 class="modal-title"></h3>
		    <div class="modal-message"></div>
		  </div>
		  <div class="modal-body"></div>
    </div>
  </body>
</html>


