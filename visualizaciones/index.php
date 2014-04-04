<?php
	$system_path = 'system';
	define('BASEPATH', str_replace("\\", "/", $system_path));
	include('../application/config/config.php');
	$baseurl = $config['base_url'];
?>
<!DOCTYPE HTML>
<html lang="es-CL">
<head>
	<meta charset="UTF-8">
	<title>Demo de visualizaciones utilizando datos abiertos.</title>
	<link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $baseurl; ?>assets/css/bootstrap-responsive.min.css">
	<style type="text/css">
		body {
			padding: 40px 0 0 0; 
			overflow: hidden; 
		}
	</style>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li class="active">
							<a href="<?php echo $baseurl; ?>visualizaciones">Visualizaciones</a>
						</li>
						<li>
							<a href="<?php echo $baseurl; ?>visualizaciones/presupuesto">Presupuesto</a>
						</li>
						<li>
							<a href="<?php echo $baseurl; ?>visualizaciones/wordcloud">WordCloud</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<h1>Visualizaciones</h1>
			<div class="row-fluid">
				<div class="span4">
					<ul class="nav nav-list">
						<li><a href="presupuesto">Presupuesto</a></li>
						<li><a href="wordcloud">WordCloud</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
