<option value="">- Seleccione -</option>
<?php foreach ($servicios as $key => $servicio){ ?>
	<?php if ($participacion->getInstitucion() == $servicio->getCodigo()) { ?>
                <option value="<?php echo $servicio->getCodigo(); ?>" selected><?php echo $servicio->getNombre(); ?></option>
              <?php }else{ ?>
                <option value="<?php echo $servicio->getCodigo(); ?>"><?php echo $servicio->getNombre(); ?></option>
         <?php } ?>
<?php } ?>
