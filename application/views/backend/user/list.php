<div class="page-header">
    <h1>Usuarios <small></small></h1>
</div>
<form action="<?php echo site_url('backend/user'); ?>" class="form-filtros form-horizontal">
    <div class="control-group">
        <div class="control-label">
            <label for="rol">Rol</label>
        </div>
        <div class="controls">
            <select  class="input-medium" name="rol" id="rol">
                <option value="">- Todos -</option>
                <?php foreach ($rols as $key => $rol){ ?>
                    <option <?php echo $rol->getId()==$rolid?'selected="selected"':''; ?> value="<?php echo $rol->getId(); ?>"><?php echo $rol->getNombre(); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="servicio">Servicio</label>
        </div>
        <div class="controls">
            <select name="servicio" id="servicio" class="input-xxlarge">
                <option value=""> - Todos - </option>
            <?php foreach ($servicios as $key => $servicio){ ?>
                <option <?php echo $servicio->getCodigo()==$serviciocodigo?'selected="selected"':''; ?> value="<?php echo $servicio->getCodigo(); ?>"><?php echo $servicio->getNombre(); ?></option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="fullname">Nombre</label>
        </div>
        <div class="controls">
            <input type="text" class="input-block-level" name="fullname" id="fullname" value="<?php echo $fullname; ?>">
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button class="btn btn-primary">Filtrar</button>
            <a class="btn btn-success" href="<?php echo current_url().'?excel=1&'.$_SERVER['QUERY_STRING'];; ?>" target="_blank">Exportar a Csv</a>
        </div>
    </div>
	<input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
	<input type="hidden" name="orderdir" id="orderdir" value="<?php echo $orderdir; ?>">
	<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>">
</form>
<a href="<?php echo site_url('backend/user/add'); ?>" class="btn btn-primary">Nuevo Usuario</a>
<table id="tabla-usuarios" class="table table-striped table-sort" data-offset="<?php echo $offset; ?>" data-order-field="<?php echo $orderby; ?>" data-order-dir="<?php echo $orderdir; ?>">
	<thead>
		<tr>
			<th>
				<a href="#" data-order-field="id">#</a>
			</th>
            <th>
                <a href="#" data-order-field="fullname">Nombre</a>
            </th>         
			<th>
				<a href="#" data-order-field="email">E-Mail</a>
			</th>
			<th>
				Roles
			</th>
			<th>
				<a href="#" data-order-field="created_at">Fecha de Creación</a>
			</th>
		</tr>
	</thead>
	<tbody>
        <?php if ($users): ?>
            <?php foreach ($users as $key => $user){ ?>
                <tr>
                    <td><?php echo $user->getId(); ?></td>
                    <td><a href="<?php echo site_url('backend/user/edit/'.$user->getId()); ?>"><?php echo $user->getFullName(); ?></a></td>
                    <td><a href="<?php echo site_url('backend/user/edit/'.$user->getId()); ?>"><?php echo $user->getEmail(); ?></a></td>
                    <td>
                        <?php
                            $a_rols = array();
                            foreach ($user->getRols() as $key => $rol){
                                $a_rols[] = $rol->getNombre();
                            }
                            echo isset($a_rols)?implode(', ', $a_rols):'';
                        ?>
                    </td>
                    <td><?php echo $user->getCreatedAt()->format('d/m/Y H:i'); ?></td>
                </tr>   
            <?php } ?>
        <?php else: ?>
            <tr>
                <td colspan="5">
                    <p class="alert pagination-centered">No se han encontrado Usuarios</p>
                </td>
            </tr>
        <?php endif ?>
	</tbody>
</table>
<?php echo $pagination; ?>