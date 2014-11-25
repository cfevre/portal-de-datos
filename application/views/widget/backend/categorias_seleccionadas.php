<option value="">- Seleccione -</option>
<?php foreach ($categorias_seleccionadas as $key => $categoria){ ?>
	<?php if ($participacion->getCategoria() == $key) { ?>
                <option value="<?php echo $key ?>" selected><?php echo $categoria->getNombre(); ?></option>
              <?php }else{ ?>
                <option value="<?php echo $key ?>"><?php echo $categoria->getNombre(); ?></option>
         <?php   } ?>
<?php } ?>
