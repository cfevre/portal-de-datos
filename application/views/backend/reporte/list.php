<div class="page-header">
    <?php if (isset($dataset)): ?>
        <h3>Reportes Dataset: <?php echo $dataset->getTitulo(); ?></h3>
    <?php else: ?>
        <h3>Reportes</h3>
    <?php endif ?>
</div>
<?php if ($user->hasRol('mantencion') && isset($dataset)): ?>
    <a href="<?php echo site_url('backend/reporte/add/'.$dataset->getId()); ?>" class="btn btn-primary">Agregar Reporte</a>
    <hr>
<?php endif ?>
<form action="<?php echo current_url(); ?>" class="form form-horizontal">
    <div class="span7">
        <div class="control-group">
            <div class="control-label">
                <label for="estado">Estado</label>
            </div>
            <div class="controls">
                <select name="estado" id="estado" class="input-block-level">
                    <option value="">- Todos -</option>
                    <?php foreach ($estados as $key => $estado){ ?>
                        <?php $selected = (intval($options['estado'])===$key)?'selected="selected"':''; ?>
                        <?php if ($key!==1 || ($key===1 && $user->hasRol('mantencion'))): ?>
                            <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $estado; ?></option>
                        <?php endif ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="tipo_reporte_id">Tipo de Reporte</label>
            </div>
            <div class="controls">
                <select name="tipo_reporte_id" id="tipo_reporte_id" class="input-block-level">
                    <option value="">- Todos -</option>
                    <?php foreach ($tiposReporte as $key => $tipoReporte){ ?>
                        <?php $selected = (intval($options['tipo_reporte_id'])===intval($tipoReporte->getId()))?'selected="selected"':''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $tipoReporte->getId(); ?>"><?php echo $tipoReporte->getTitulo(); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php if (!isset($options['dataset_id'])): ?>
            <div class="control-group">
                <div class="control-label">
                    <label for="codigo_servicio">Servicio</label>
                </div>
                <div class="controls">
                    <select name="codigo_servicio" id="codigo_servicio" class="input-block-level">
                        <option value="">- Todos -</option>
                        <?php foreach ($servicios as $key => $servicio){ ?>
                            <?php $selected = ($options['codigo_servicio']===$servicio->getCodigo())?'selected="selected"':''; ?>
                            <option <?php echo $selected; ?> value="<?php echo $servicio->getCodigo(); ?>"><?php echo $servicio->getNombre(); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox" for="muestra_despublicados">
                        <input type="checkbox" class="input-medium" name="muestra_despublicados" id="muestra_despublicados" value="1" <?php echo $options['muestra_despublicados']?'checked="checked"':''; ?>>
                        Muestra los reportes de datasets despublicados
                    </label>
                </div>
            </div>
        <?php endif; ?>
        <div class="controlgroup">
            <div class="controls">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a target="_blank" class="btn btn-success" href="<?php echo current_url().'?excel=1'.($_SERVER['QUERY_STRING']?'&'.$_SERVER['QUERY_STRING']:''); ?>">Exportar a CSV</a>
            </div>
        </div>
    </div>
    <div class="span5">
        <?php if (!isset($dataset)): ?>
            <?php echo widgetHelper::reportes(); ?>
        <?php endif ?>
    </div>
    <div class="clearfix"></div>
</form>
<hr>
<?php echo $pagination; ?>
<?php
    $extra_params = $options['estado']?'&estado='.$options['estado']:'';
    $extra_params .= $options['tipo_reporte_id']?'&tipo_reporte_id='.$options['tipo_reporte_id']:'';
    $extra_params .= $options['codigo_servicio']?'&codigo_servicio='.$options['codigo_servicio']:'';
    $extra_params .= $options['muestra_despublicados']?'&muestra_despublicados='.$options['muestra_despublicados']:'';
?>
<table id="tabla-reportes" class="table table-striped table-sort"  data-offset="<?php echo $options['offset']; ?>" data-order-field="<?php echo $options['orderby']; ?>" data-order-dir="<?php echo $options['orderdir']; ?>" data-extra-params="<?php echo $extra_params; ?>">
    <thead>
        <tr>
            <th>
                <a href="#" data-order-field="r.id">#</a>
            </th>
            <th>
                <a href="#" data-order-field="d.titulo">Titulo del Dataset</a>
            </th>
            <th>
                <a href="#" data-order-field="t.titulo">Tipo de reporte</a>
            </th>
            <th>
                <a href="#" data-order-field="g.nombre">Grado del reporte</a>
            </th>
            <th>
                <a href="#" data-order-field="r.estado">Estado</a>
            </th>
            <th>
                <a href="#" data-order-field="r.created_at">Fecha de ingreso</a>
            </th>
            <th>
                <a href="#" data-order-field="r.updated_at">Última actualización</a>
            </th>
            <th>
                Acciones
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($reportes)): ?>
            <?php foreach ($reportes as $key => $reporte){ ?>
                <tr>
                    <td><?php echo $reporte->getId(); ?></td>
                    <td><?php echo $reporte->getDataset()->getTitulo(); ?></td>
                    <td><?php echo $reporte->getTipoReporte()->getTitulo(); ?></td>
                    <td><?php echo $reporte->getTipoReporte()->getGradoReporte()->getNombre(); ?></td>
                    <td><?php echo $reporte->getEstado(true); ?></td>
                    <td nowrap><?php echo $reporte->getCreatedAt()->format('d/m/Y H:i'); ?></td>
                    <td nowrap><?php echo $reporte->getUpdatedAt()?$reporte->getUpdatedAt()->format('d/m/Y H:i'):''; ?></td>
                    <td nowrap>
                        <a href="<?php echo site_url('backend/reporte/view/'.$reporte->getId()); ?>" class="btn btn-primary btn-small"><i class="icon-eye-open icon-white"></i> Ver</a>
                        <?php if ($user->hasRol('mantencion')): ?>
                            <a href="<?php echo site_url('backend/reporte/edit/'.$reporte->getId()); ?>" class="btn btn-success btn-small"><i class="icon-edit icon-white"></i> Editar</a>
                            <button data-id="<?php echo $reporte->getId(); ?>" data-name="<?php echo $reporte->getTipoReporte()->getTitulo(); ?>" class="btn btn-small btn-danger delete-reporte"><i class="icon-remove icon-white"></i> Eliminar</button>
                        <?php elseif(in_array(intval($reporte->getEstado()),array(2,5))): ?>
                            <a href="<?php echo site_url('backend/reporte/revisar/'.$reporte->getId()); ?>" class="btn btn-success btn-small">Enviar a revisión</a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php } ?>
        <?php else: ?>
            <tr>
                <td colspan="8">
                    No hay reportes ingresados para este dataset
                </td>
            </tr>
        <?php endif ?>
    </tbody>
</table>
<?php echo $pagination; ?>