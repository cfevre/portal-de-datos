<?php foreach ($total_categorias as $key => $categoria){ ?>
	<option value="<?php echo $categoria->getId(); ?>"><?php echo $categoria->getNombre(); ?></option>
<?php } ?>
