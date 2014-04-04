<div class="span8">
	<h3><?php echo $page_title; ?></h3>
	<?php echo widgetHelper::compartirRedesSociales(); ?>
	<?php foreach ($entidades as $key => $entidad){ ?>
		<ul>
			<li>
				<a href="<?php echo site_url('entidades/ver/'.$entidad->getCodigo()); ?>"><?php echo $entidad->getNombre(); ?></a>
				<?php if($entidad->getServicio()){ ?>
					<ul>
						<?php foreach ($entidad->getServicio() as $key => $servicio){ ?>
							<li><a href="<?php echo site_url('servicios/ver/'.$servicio->getCodigo()); ?>"><?php echo $servicio->getNombre(); ?> (<?php echo $servicio->getDataset()->count(); ?>)</a></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</li>
		</ul>
	<?php } ?>
</div>
<div class="span4 side-bar">
	<?php echo widgetHelper::etiquetasPopulares(); ?>
    <?php echo widgetHelper::categoriasConMasDatasets(); ?>
</div>