<div class="page-header">
    <h1>Servicios</h1>
    <div class="clearfix"></div>
</div>
<form action="<?php echo site_url('backend/servicio'); ?>" class="form-filtros form-horizontal">
    <div class="span12">
        <div class="control-group">
            <div class="control-label">
                <label for="nombre_servicio">Nombre</label>
            </div>
            <div class="controls">
                <input type="text" class="input-block-level" name="nombre_servicio" id="nombre_servicio" value="<?php echo $nombre_servicio; ?>">
            </div>
        </div>
        <?php if ($entidades): ?>
            <div class="control-group">
                <div class="control-label">
                    <label for="entidad_codigo">Entidad</label>
                </div>
                <div class="controls">
                    <select name="entidad_codigo" id="entidad_codigo" class="input-block-level">
                        <option value="">- Todas -</option>
                        <?php foreach ($entidades as $key => $entidad){ ?>
                            <?php $selected = $entidad_codigo == $entidad->getCodigo() ? 'selected="selected"' : ''; ?>
                            <option <?php echo $selected; ?> value="<?php echo $entidad->getCodigo(); ?>"><?php echo $entidad->getNombre(); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        <?php endif ?>
        <div class="control-group">
            <div class="control-label">
                &nbsp;
            </div>
            <div class="controls">
                <label for="con_recurso" class="checkbox">
                    Sólo servicios que tengan datasets con recursos
                    <input type="checkbox" value="s" <?php echo $con_recurso?'checked="checked"':''; ?> name="con_recurso" id="con_recurso">
                </label>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="">&nbsp;</label>
            </div>
            <div class="controls">
                <button class="btn btn-primary">Filtrar</button>
            </div>
        </div>
        <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
        <input type="hidden" name="orderdir" id="orderdir" value="<?php echo $orderdir; ?>">
        <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>">
    </div>
    <div class="clearfix"></div>
    <a href="<?php echo site_url('backend/servicio/add'); ?>" class="btn btn-primary">Nuevo Servicio</a>
</form>
<hr>
<?php echo $pagination; ?>
<table id="tabla-servicios" class="table table-striped table-sort" data-offset="<?php echo $offset; ?>" data-order-field="<?php echo $orderby; ?>" data-order-dir="<?php echo $orderdir; ?>">
    <thead>
    <tr>
        <th>
            <a href="#" data-order-field="s.codigo">#</a>
        </th>
        <th>
            <a href="#" data-order-field="s.nombre">Título</a>
        </th>
        <th>
            <a href="#" data-order-field="s.publicado">Estado</a>
        </th>
        <th>
            <a href="#" data-order-field="total_datasets">Cantidad de Datasets</a>
        </th>
        <th>
            Acciones
        </th>
    </tr>
    </thead>
    <tbody>
    <?php if ($servicios): ?>
        <?php foreach ($servicios as $key => $servicio){ ?>
            <tr id="servicio-<?php echo $servicio['servicio']->getCodigo(); ?>">
                <td><?php echo $servicio['servicio']->getCodigo(); ?></td>
                <td><a href="<?php echo site_url('backend/servicio/view/'.$servicio['servicio']->getCodigo()); ?>"><?php echo $servicio['servicio']->getNombre(); ?></a></td>
                <td>
                    <?php if(!$servicio['servicio']->getPublicado()){ ?>
                        <span class="label label-mini label-warning">
                                <i class="icon-ban-circle"></i>
                                <span>No Publicado</span>
                            </span>
                    <?php }else{ ?>
                        <span class="label label-mini label-success">
                                <i class="icon-ok-circle"></i>
                                <span>Publicado</span>
                            </span>
                    <?php } ?>
                </td>
                <td>
                    <?php echo $servicio['total_datasets'];?>
                </td>
                <td nowrap>
                    <?php if ($this->user->hasRol('ingreso') || $this->user->hasRol('publicacion')): ?>
                        <a class="btn btn-small btn-success" href="<?php echo site_url('backend/servicio/edit/'.$servicio['servicio']->getCodigo()); ?>"><i class="icon-edit icon-white"></i> <strong>Editar</strong></a>
                    <?php endif ?>

                    <?php /*if ($this->user->hasRol('ingreso')): ?>
                        <button data-id="<?php echo $servicio['servicio']->getCodigo(); ?>" data-name="<?php echo $servicio['servicio']->getNombre(); ?>" class="btn btn-small btn-danger delete-servicio"><i class="icon-remove icon-white"></i> <strong>Eliminar</strong></button>
                    <?php endif*/ ?>
                </td>
            </tr>
        <?php } ?>
    <?php else: ?>
        <tr>
            <th style="text-align:center" colspan="5">No se han encontrado Servicios.</th>
        </tr>
    <?php endif ?>
    </tbody>
</table>
<?php echo $pagination; ?>