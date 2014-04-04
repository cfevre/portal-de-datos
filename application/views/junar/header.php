<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es-CL"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="es-CL"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="es-CL"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es-CL"> <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width" />

    <title><?php echo $data['page_title']; ?></title>

    <link href="http://fonts.googleapis.com/css?family=Ubuntu:bold" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('assets/img/apple-touch-icon-precomposed.png') ?>">
    <script src="<?php echo base_url('assets/js/libs/modernizr-2.5.3.min.js') ?>"></script>
  </head>
  <body>
		<div class="navbar navbar-inverse header">
			<div class="navbar-inner">
				<div class="container">
					<a href="<?php echo site_url(); ?>" class="brand"><span>Datos</span>.gob.cl</a>
					<?php echo widgetHelper::buscador(); ?>
				</div>
			</div>
		</div>
    <div class="navbar menu-principal">
      <?php echo $blocks['main_menu']; ?>
    </div>
    <div class="main">
			<div class="container">
				<div class="row-fluid">
					<div class="span12">
						<?php echo $blocks['breadcrumb']; ?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo base_url('assets/js/libs/jquery-1.8.1.min.js'); ?>"></script>
    <script type="text/javascript">
      window.____aParams = {"gobabierto":"1","buscadore":"1","domain":"www.chilesinpapeleo.cl","icons":"1"};
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.modernizacion.cl/barra/js/barraEstado.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
		<script type="text/javascript">
			(function($){
				$(document).on('click', 'a', function(e){
					window.parent.location = $(this).attr('href');
					e.preventDefault();
				});
			})(jQuery);
		</script>
	</body>
</html>