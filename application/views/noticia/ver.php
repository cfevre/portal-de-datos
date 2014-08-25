<div class="noticias-ver span8">
	<section class="body" itemscope itemtype="http://www.schema.org/Article">
	 	<div class="row-fluid">
	 		<div class="span9">
				<h2>
					<?php echo $noticia->getTitulo(); ?>
				</h2>
	 		</div>
	 		<div class="span3">
				<time itemprop="dateCreated" datetime="<?= strftime('%Y-%m-%d', $noticia->getPublicadoAt()->getTimestamp()) ?>"><?= strftime('%e de %B del %Y', $noticia->getPublicadoAt()->getTimestamp()) ?></time>
			</div>
		</div>
		<?php echo widgetHelper::compartirRedesSociales(); ?>
    <div>
      <a class="imagen-noticia" href="<? echo site_url('noticias/ver/' . $noticia->getId()) ?>">
      	<img src="<?php echo base_url('assets/timthumb/timthumb.php?zc=1&w=440&src=uploads/noticias/'.$noticia->getFoto()); ?>" alt="<?php echo $noticia->getTitulo(); ?>" />
      </a>
      <p itemprop="review" class="resumen">
      	<?= $noticia->getResumen() ?>
      </p>


      <p itemprop="articleBody">
      	<?= $noticia->getContenido() ?>
      </p>
    </div>
  </section>
</div>
<div class="span4 side-bar">
    <?php echo widgetHelper::categoriasConMasDatasets(); ?>
	<?php echo widgetHelper::etiquetasPopulares(); ?>
	<?php echo widgetHelper::catalogosMasDescargados(10); ?>
</div>