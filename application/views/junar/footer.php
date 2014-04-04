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
    <script src="<?php echo base_url('assets/js/libs/modernizr-2.5.3.min.js') ?>"></script>
  </head>
  <body>
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
			(function($){
				$(document).on('click', 'a', function(e){
					window.parent.location = $(this).attr('href');
					e.preventDefault();
				});
			})(jQuery);
		</script>
	</body>
</html>