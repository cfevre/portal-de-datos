<option value="">- Seleccione -</option>
<?php foreach ($entidades as $key => $entidad) { ?>              
    <option value="<?php echo $entidad->getCodigo(); ?>"><?php echo $entidad->getNombre(); ?></option>
<?php } ?>