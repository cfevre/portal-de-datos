<?php
	$system_path = 'system';
	define('BASEPATH', str_replace("\\", "/", $system_path));
	include('../../application/config/config.php');
	$baseurl = $config['base_url'];
?>
<!DOCTYPE HTML>
<html lang="es-CL">
<head>
	<meta charset="UTF-8">
	<title>Nube de términos en servicios públicos</title>
	<link rel="stylesheet" href="<?php echo $baseurl; ?>/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $baseurl; ?>/assets/css/bootstrap-responsive.min.css">
	<style type="text/css">
		body {
			padding: 40px 0 0 0; 
			position: relative;
		}
	</style>
  <script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
  <script type="text/javascript" src="js/d3.js?2.7.4"></script>
  <script type="text/javascript" src="js/stopwords.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li>
							<a href="<?php echo $baseurl; ?>visualizaciones">Visualizaciones</a>
						</li>
						<li>
							<a href="<?php echo $baseurl; ?>visualizaciones/presupuesto">Presupuesto</a>
						</li>
						<li class="active">
							<a href="<?php echo $baseurl; ?>visualizaciones/wordcloud">WordCloud</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container" id="container">
		<div class="row">
			<h1 id='bubble_chart'>WordCloud ChileAtiende<small>Palabras mas usadas</small></h1>
			<form action="" class="form form-horizontal">
			  <div class="control-group">
			  	<div class="control-label">
			  		<label for="lista">Servicios</label>
			  	</div>
			  	<div class="controls">
				  	<select id="lista" class="input-xxlarge">
				  		<option>Seleccione un servicio</option>
				  	</select>
				  	<span id="waiting" style="display: none"><img src='img/waiting.gif '/></span>
			  	</div>
			  </div>
			</form>
			<div class='gallery' id='chart'> </div>
			<link href='css/bubble.css' rel='stylesheet' type='text/css' />
			<script src='js/d3.layout.js' type='text/javascript'> </script>
			<script src='js/bubble.js' type='text/javascript'> </script>
		</div>
	</div>
</body>
</html>

