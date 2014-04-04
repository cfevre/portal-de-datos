<?php
	$system_path = 'system';
	define('BASEPATH', str_replace("\\", "/", $system_path));
	include('../../application/config/config.php');
	$baseurl = $config['base_url'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>Presupuesto</title>
<link rel="stylesheet" href="<?php echo $baseurl; ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $baseurl; ?>/assets/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="css/style.page.css" />
<link rel="stylesheet" type="text/css" href="css/style.bubbletree.css" />
<link rel="stylesheet" type="text/css" href="css/style.tooltips.css" />
<script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="js/jquery.history.js"></script>
<script type="text/javascript" src="js/raphael.js"></script>
<script type="text/javascript" src="js/vis4.js"></script>
<script type="text/javascript" src="js/Tween.js"></script>
<script type="text/javascript" src="js/bubbletree.min.js"></script>
<script type="text/javascript" src="js/style.cofog.js"></script>
<script type="text/javascript" src="js/config.js"></script>
<script type="text/javascript" src="js/csv2json.js"></script>
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
					<li class="active">
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
<div class="container" id="container">
	<div class="row">
		<h1>Presupuesto 2012 <small>beta</small></h1>
		<form action="" class="form form-horizontal">
			<div class="control-group">
				<div class="control-label">
					<label for="data">Seleccione una Institución</label>
				</div>
				<div class="controls">
					<select id="data" class="input-xxlarge">
						<option value="articles-84112_doc_csv.csv">Modernización y Gobierno Electrónico</option>
						<option value="articles-84111_doc_csv.csv">Secretaría General de la Presidencia de la República</option>
						<option value="articles-83826_doc_csv.csv">Presidencia de la República</option>
					</select>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="bubbletree-wrapper">
	<div class="bubbletree"></div>
</div>
</body>
</html>
