<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es-CL" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="es-CL" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="es-CL" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es-CL" xmlns:fb="http://ogp.me/ns/fb#"> <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="Portal de Datos Públicos - Gobierno de Chile" />
    <meta http-equiv="Content-Language" content="es-CL" />
    <meta name="google-site-verification" content="a5NvwGQOwtqJ-SrJqFqvb4FXKt9pFlVzs70rY56Nk-o" />
    <meta name="keywords" content="datos, transparencia, open data, ogov, gobierno abierto, mapas, instituciones, Estado, Gobierno de Chile" />
        
    <meta name="viewport" content="width=device-width" />

    <title><?php echo $data['page_title']; ?></title>

    <link rel="alternate" type="application/rss+xml" title="Datos.gob.cl - Datasets más nuevos" href="<? echo site_url('datasets/rss/nuevos');  ?>" />
    <link rel="alternate" type="application/rss+xml" title="Datos.gob.cl - Datasets más descargados" href="<? echo site_url('datasets/rss/descargas'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="Datos.gob.cl - Datasets más evaluados" href="<? echo site_url('datasets/rss/evaluacion'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="Datos.gob.cl - Datasets ordenados por nombre" href="<? echo site_url('datasets/rss/nombre'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="Datos.gob.cl - Noticias" href="<? echo site_url('noticias/rss'); ?>" />
    <link href="http://fonts.googleapis.com/css?family=Ubuntu:bold" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css?1') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/print.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.rating.css') ?>">
    <?php foreach ($stylesheets as $key => $stylesheet){ ?>
   		<link rel="stylesheet" href="<?php echo $stylesheet; ?>" />
    <?php } ?>
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico') ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('assets/img/apple-touch-icon-precomposed.png') ?>">

      <!-- copyright Modernizr MIT license. -->
    <script src="<?php echo base_url('assets/js/libs/modernizr-2.5.3.min.js') ?>"></script>
      <!-- copyright Modernizr -->

  </head>
  <body>
	<div class="navbar navbar-inverse header">
			<div class="navbar-inner">
				<div class="container">
					<a href="<?php echo site_url(); ?>" class="brand"><span>datos</span>.gob.cl</a>
					<?php echo widgetHelper::buscador(); ?>
				</div>
			</div>
	</div>
	<!--MENU-->
    <div id="movible" class="navbar menu-principal">
      <?php echo $blocks['main_menu']; ?>
    </div>
    <div id="box-solid"></div>
    <div class="main">
			<div class="container">
				<?php if(isset($navItem) && !$navItem->getHomepage()){ ?>
					<div class="row-fluid">
						<div class="span12">
							<?php echo $blocks['breadcrumb']; ?>
						</div>
					</div>
				<?php } ?>
				<?php echo $blocks['messages']; ?>
				<div class="row-fluid">
		    	<?php echo $blocks['content']; ?>
		        </div>
		  </div>
	  </div>
	  <footer class="footer">
		  <div class="container">
		    <div class="row-fluid">
		      <div class="span3 links">
		      	<?php echo $blocks['enlaces_internos']; ?>
		      </div>
		      <div class="span4 links">
		      	<?php echo $blocks['sitios_relacionados']; ?>
		      </div>
		      <div class="span3 info">
		      	<p>
		      		<a href="http://www.gobiernodechile.cl/" target="_blank">Gobierno de Chile</a><br>
		      		<a href="http://www.modernizacion.gob.cl" target="_blank">Modernización y Gobierno Digital</a> <br>
			        <a href="http://www.minsegpres.gob.cl/" target="_blank">Ministerio Secretaría General de la Presidencia</a></p>
			      <p>
			      	<a rel="license" href="http://creativecommons.org/licenses/by/3.0/cl/"><img alt="Licencia Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/cl/80x15.png" /></a>
			      </p>
		      </div>
		      <div class="span2 info">
			      <p><a href="http://www.modernizacion.gob.cl" target="_blank"><img src="<?php echo base_url('assets/img/footer/logo_MyGD.png'); ?>" alt="logo modernización"></a></p>
		      </div>
	      </div>
		  </div>
	  </footer>

	  <script type="text/javascript" src="<?php echo base_url('assets/js/libs/jquery-1.8.1.min.js'); ?>"></script>
	  <script src="<?php echo base_url('assets/js/libs/bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/libs/jquery.rating.js') ?>"></script>
	  <script src="<?php echo base_url('assets/js/script.js') ?>"></script>
	  <?php foreach ($scripts as $key => $script){ ?>
    	<script type="text/javascript" src="<?php echo $script; ?>"></script>
    <?php } ?>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo $this->config->item("ga_account"); ?>']);
        _gaq.push(['_setDomainName', '<?php echo $this->config->item("ga_domain_name"); ?>']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <script type="text/javascript">
      window.____aParams = {"gobabierto":"1","buscadore":"1","domain":"www.chilesinpapeleo.cl","icons":"1"};
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.modernizacion.cl/barra/js/barraEstado.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <input id="site_url" name="site_url" type="hidden" value="<?php echo site_url(); ?>">
	</body>
</html>
