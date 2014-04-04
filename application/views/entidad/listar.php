<div class="span8">
	<div class="cont-widget" id="widget-datasets-por-filtro">
		<div class="widget-header">
			<h3>Instituciones publicadoras</h3>
			<?php echo widgetHelper::compartirRedesSociales(); ?>
		</div>
		<div class="widget-content">
			<div class="cont-listado-entidades clear-list">
				<?php foreach ($entidades as $key => $entidad){ ?>
					<ul class="unstyled cont-entidad-dataset">
						<li>
							<a href="<?php echo site_url('entidades/ver/'.$entidad->getCodigo()); ?>"><?php echo $entidad->getNombre(); ?></a>
							<?php if($entidad->getServiciosPublicados()){ ?>
								<ul>
									<?php foreach ($entidad->getServiciosPublicados() as $key => $servicio){ ?>
										<li><a href="<?php echo site_url('servicios/ver/'.$servicio->getCodigo()); ?>"><?php echo $servicio->getNombre(); ?> (<?php echo $servicio->getDataset()->count(); ?>)</a></li>
									<?php } ?>
								</ul>
							<?php } ?>
						</li>
					</ul>
				<?php } ?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="span4 side-bar">
	<?php echo widgetHelper::etiquetasPopulares(); ?>
</div>