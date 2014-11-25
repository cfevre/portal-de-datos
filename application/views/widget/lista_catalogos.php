<?php foreach ($entidades as $key => $entidad){ ?>
             <div class="cont-entidad-dataset">
                    <?php if ($entidad->getServicio()->count()>3): ?>
                        <a href="#" class="ver-mas-servicios">Ver más</a>
                    <?php endif ?>
    				<ul class="unstyled entidad-dataset">
    					<li>
    						<a href="<?php echo site_url('entidades/ver/'.$entidad->getCodigo()); ?>"><?php echo $entidad->getNombre(); ?> (<?php echo $entidad->getTotalDatasets(); ?>)</a>
    					</li>
    				</ul>
                </div>            
<?php } ?>

