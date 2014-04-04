<div class="page-header">
    <h1>Datasets <small></small></h1>
    <div class="clearfix"></div>
</div>
<form action="<?php echo site_url('backend/dataset'); ?>" class="form-filtros form-horizontal">
    <div class="span7">
    <?php if ($entidades): ?>
        <div class="control-group">
            <div class="control-label">
                <label for="codigo_entidad">Entidad</label>
            </div>
            <div class="controls">
                <select name="codigo_entidad" id="codigo_entidad" class="input-block-level">
                    <option value="">- Todas -</option>
                    <?php foreach ($entidades as $key => $entidad){ ?>
                        <?php $selected = $codigo_entidad == $entidad->getCodigo() ? 'selected="selected"' : ''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $entidad->getCodigo(); ?>"><?php echo $entidad->getNombre(); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    <?php endif ?>
    <?php if ($servicios): ?>
        <div class="control-group">
            <div class="control-label">
                <label for="codigo_servicio">Servicio</label>
            </div>
            <div class="controls">
                <select name="codigo_servicio" id="codigo_servicio" class="chzn-select input-block-level">
                    <option value="">- Todos -</option>            
                    <?php foreach ($servicios as $key => $servicio){ ?>
                        <?php $selected = $codigo_servicio == $servicio->getCodigo() ? 'selected="selected"' : ''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $servicio->getCodigo(); ?>"><?php echo $servicio->getNombre(); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>        
    <?php endif ?>
    <?php if ($servicios || $entidades): ?>
        <div class="control-group">
            <div class="control-label">
                <label for="q">Texto</label>
            </div>
            <div class="controls">
                <input type="text" class="input-block-level" name="q" id="q" value="<?php echo $q; ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">

            </div>
            <div class="controls">
                <label for="junar" class="checkbox">
                    <input type="checkbox" value="s" <?php echo $junar?'checked="checked"':''; ?> name="junar" id="junar"> Integrado con Junar
                </label>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                &nbsp;
            </div>
            <div class="controls">
                <label for="con_recurso" class="checkbox">
                    Sólo datasets con recursos
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
                <a class="btn btn-success" href="<?php echo current_url().'?excel=1&'.$_SERVER['QUERY_STRING'];; ?>" target="_blank">Exportar a Csv</a>

            </div>
        </div>
    <?php endif ?>
        <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
        <input type="hidden" name="orderdir" id="orderdir" value="<?php echo $orderdir; ?>">
        <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>">
        <a href="<?php echo site_url('backend/dataset/add'); ?>" class="btn btn-primary">Nuevo Dataset</a>
    </div>
    <div class="span5">
        <?php echo widgetHelper::reportes(); ?>
    </div>
    <div class="clearfix"></div>
</form>
<hr>
<?php echo $pagination; ?>
<table id="tabla-datasets" class="table table-striped table-sort" data-offset="<?php echo $offset; ?>" data-order-field="<?php echo $orderby; ?>" data-order-dir="<?php echo $orderdir; ?>">
    <thead>
        <tr>
            <th>
                <a href="#" data-order-field="d.id">#</a>
            </th>
            <th>
                <a href="#" data-order-field="d.titulo">Título</a>
            </th>
            <th>
                <a href="#" data-order-field="d.publicado">Estado</a>
            </th>
            <th nowrap>
                <a href="#" data-order-field="d.updated_at">Última Modificación</a>
            </th>
            <th>
                Acciones
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if ($datasets): ?>
            <?php foreach ($datasets as $key => $dataset){ ?>
                <tr id="dataset-<?php echo $dataset->getId(); ?>">
                    <td><?php echo $dataset->getId(); ?></td>
                    <td><a href="<?php echo site_url('backend/dataset/view/'.$dataset->getId()); ?>"><?php echo $dataset->getTitulo(); ?></a></td>
                    <td>
                        <?php if(!$dataset->getPublicado()){ ?>
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
                        <?php if ($dataset->getCantidadReportesPorEstados(array(2,5)) && $dataset->getPublicado()): ?>
                            <br><a href="<?php echo site_url('backend/reporte/dataset/'.$dataset->getId()); ?>" class="label label-mini label-important"><i class="icon-exclamation-sign"></i> Reportes pendientes</a>
                        <?php endif ?>
                        <?php if ($user->hasRol('mantencion') && $dataset->getCantidadReportesPorEstados(array(3)) && $dataset->getPublicado()): ?>
                            <br><a href="<?php echo site_url('backend/reporte/dataset/'.$dataset->getId()); ?>" class="label label-mini label-info"><i class="icon-exclamation-sign"></i> Reportes pendientes de aprobación</a>
                        <?php endif ?>
                    </td>
                    <td><?php echo $dataset->getUpdatedAt()->format('d/m/Y H:i'); ?></td>
                    <td nowrap>
                        <?php if ($this->user->hasRol('ingreso') || $this->user->hasRol('publicacion')): ?>
                            <a class="btn btn-small btn-success" href="<?php echo site_url('backend/dataset/edit/'.$dataset->getId()); ?>"><i class="icon-edit icon-white"></i> <strong>Editar</strong></a>
                        <?php endif ?>
                        <?php if ($this->user->hasRol('ingreso')): ?>
                            <button data-id="<?php echo $dataset->getId(); ?>" data-name="<?php echo $dataset->getTitulo(); ?>" class="btn btn-small btn-danger delete-dataset"><i class="icon-remove icon-white"></i> <strong>Eliminar</strong></button>
                        <?php endif ?>
                    </td>
                </tr>    
            <?php } ?>
        <?php else: ?>
            <tr>
                <th style="text-align:center" colspan="5">No se han encontrado Datasets.</th>
            </tr>            
        <?php endif ?>
    </tbody>
</table>
<?php echo $pagination; ?>