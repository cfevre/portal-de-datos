<?php foreach ($categorias_seleccionadas as $key => $categoria){ ?>
	<option <?php echo $participacion->hasCategoria($categoria)?'selected="selected"':''; ?> value="<?php echo $categoria->getId(); ?>">
		<?php echo $categoria->getNombre(); ?>
	</option>
<?php } ?>
