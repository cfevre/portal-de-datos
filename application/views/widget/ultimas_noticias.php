<div class="cont-widget cont-ultimas-noticias">
	<h2 class="ultimas-noticias">Últimas Noticias</h2>
	<div class="cont-noticias">
		<ul class="nav nav-pills nav-stacked">
			<?php foreach ($noticias as $key => $noticia) { ?>
				<li>
					<p><?php echo strftime('%e de %B del %Y',$noticia->getUpdatedAt()->getTimestamp()); ?></p>
					<p><a href="<?php echo site_url('noticias/ver/'.$noticia->getId()) ?>"><?php echo $noticia->getTitulo(); ?></a></p>
				</li>
			<?php } ?>
		</ul>
</div>
</div>