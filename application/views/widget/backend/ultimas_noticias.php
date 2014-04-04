<div class="page-header">
  <a href="<?php echo site_url('backend/noticia/add'); ?>" class="pull-right btn btn-success">Nueva Noticia</a>
  <h3>Últimas Noticias</h3>
</div>
<div class="cont-noticias">
	<ul class="nav nav-pills nav-stacked">
		<?php foreach ($noticias as $key => $noticia) { ?>
			<li>
				<a href="<?php echo site_url('backend/noticia/edit/'.$noticia->getId()) ?>"><?php echo $noticia->getTitulo(); ?></a>
			</li>
		<?php } ?>
	</ul>
</div>
