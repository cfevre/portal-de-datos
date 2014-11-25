<div class="cont-widget" id="widget-datasets-por-filtro">
	<div class="widget-header">
	<!--
		<div class="cont-filtros-datasets pull-right">
			<form action="" class="form-inline">		
				<label for="filtro-datasets">Ordenar por: </label>
				<select name="filtro-datasets" id="filtro-datasets">
					<option value="entidad">Por Entidad</option>
				</select>
			</form>
		</div>
	-->
		<h3>Instituciones publicadoras</h3>
	</div>
	<div class="widget-content">
		<div class="cont-listado-entidades clear-list">
			<?php foreach ($entidades as $key => $entidad){ ?>
                <div class="cont-entidad-dataset">
                    <?php if ($entidad->getServicio()->count()>3): ?>
                        <a href="#" class="ver-mas-servicios">Ver más</a>
                    <?php endif ?>
    				<ul class="unstyled entidad-dataset">
    					<li>
    						<a href="<?php echo site_url('entidades/ver/'.$entidad->getCodigo()); ?>"><?php echo $entidad->getNombre(); ?> (<?php echo $entidad->getTotalDatasets(); ?>)</a>
    						<?php if($entidad->getServicio()){ ?>
    							<ul>
    								<?php foreach ($entidad->getServicio() as $key => $servicio){ ?>
    									<li><a href="<?php echo site_url('servicios/ver/'.$servicio->getCodigo()); ?>"><?php echo $servicio->getNombre(); ?> (<?php echo $servicio->getDataset()->count(); ?>)</a></li>
    								<?php } ?>
    							</ul>
    						<?php } ?>
    					</li>
    				</ul>
                </div>            
			<?php } ?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>