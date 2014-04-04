<div class="noticias-listar span8">
	<div class="row-fluid">
		<div class="span8">
			<h2 class="noticias">
				Noticias
			</h2>
		</div>
		<div class="span4">
			<form class="form-search" id="formOrdenarPor" action="<?php echo current_url(); ?>" method="GET">
				<label for="orderby">Ordenar por</label>
				<select name="orderby" id="orderby" data-auto-submit="change" data-submit-form="formOrdenarPor">
					<option value="created_at"<?php echo $orderby=='created_at'?' selected="selected"':''; ?>>Mas nuevos</option>
			    <option value="titulo"<?php echo $orderby=='titulo'?' selected="selected"':''; ?>>Por nombre</option>
				</select>
			</form>
	  </div>
  </div>
  <div class="lista-noticias">
		<?php foreach ($noticias as $key => $noticia){ ?>
		<div class="row-fluid borde-b">
			<?php if($noticia->getFoto()){ ?>
			<div class="span4">
				<div class="cont-image">
					<img src="<?php echo base_url('assets/timthumb/timthumb.php?zc=1&w=275&h=180&src=uploads/noticias/'.$noticia->getFoto()); ?>" alt="">
				</div>
			</div>
			<?php } ?>
			<div class="<?php echo $noticia->getFoto()?'span8':'span12'; ?>">
				<h4>
					<a href="<?php echo site_url('noticias/ver/'.$noticia->getId()); ?>"><?php echo $noticia->getTitulo(); ?></a>
				</h4>
				<p><?php echo $noticia->getResumen(); ?></p>
				<div class="row-fluid bottom-noticia">
					<div class="pull-right">
						<a href="<?php echo site_url('noticias/ver/'.$noticia->getId()); ?>">
							Leer mas
						</a>
					</div>
					<div class="pull-left">
						<?php echo strftime('%e de %B del %Y',$noticia->getPublicadoAt()->getTimestamp()); ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php echo $pagination; ?>
</div>
<div class="span4 side-bar">
    <?php echo widgetHelper::categoriasConMasDatasets(); ?>
	<?php echo widgetHelper::etiquetasPopulares(); ?>
	<?php echo widgetHelper::catalogosMasDescargados(10); ?>
</div>