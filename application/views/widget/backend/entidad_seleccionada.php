<option value="">- Seleccione -</option>
<?php foreach ($servicios['items'] as $key => $value){ ?>
	<?php if ($participacion->getInstitucion() == $value['codigo']) { ?>
                <option value="<?php echo $value['codigo'] ?>" selected><?php echo $value['nombre'] ?></option>
              <?php }else{ ?>
                <option value="<?php echo $value['codigo'] ?>"><?php echo $value['nombre'] ?></option>
         <?php } ?>
<?php } ?>
