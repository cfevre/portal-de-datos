<option value="">- Seleccione -</option>
<?php foreach ($servicios as $key => $servicio) { ?>              
    <option value="<?php echo $servicio->getCodigo(); ?>"><?php echo $servicio->getNombre(); ?></option>
<?php } ?>