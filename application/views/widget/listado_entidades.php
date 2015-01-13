
<option value="">- Seleccione -</option>
<?php foreach ($servicios['items'] as $key => $value) { ?>              
    <option value="<?php echo $value['codigo'] ?>"><?php echo $value['nombre'] ?></option>
<?php } ?>