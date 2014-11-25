<option value="">- Seleccione -</option>
<?php foreach ($entidades as $key => $entidad){ ?>
	<?php if ($participacion->getInstitucion() == $entidad->getCodigo()) { ?>
                <option value="<?php echo $entidad->getCodigo(); ?>" selected><?php echo $entidad->getNombre(); ?></option>
              <?php }else{ ?>
                <option value="<?php echo $entidad->getCodigo(); ?>"><?php echo $entidad->getNombre(); ?></option>
         <?php } ?>
<?php } ?>
