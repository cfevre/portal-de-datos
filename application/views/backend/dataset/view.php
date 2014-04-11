<h3>Dataset: <?php echo $dataset->getTitulo(); ?></h3>
<?php if ($this->user->hasRol('publicacion')): ?>
    <?php if ($dataset->getMaestro()): ?>
        <a href="<?php echo site_url('backend/dataset/versions/'.$dataset->getId()); ?>" class="btn btn-primary">Cambiar versión Publicada</a>
    <?php else: ?>
        <?php if ($dataset->getPublicado()): ?>
            <a href="<?php echo site_url('backend/dataset/versions/'.$dataset->getDatasetMaestro()->getId()); ?>" class="btn btn-primary">Cambiar versión Publicada</a>
        <?php else: ?>
            <a href="<?php echo site_url('backend/dataset/versions/'.$dataset->getDatasetMaestro()->getId()); ?>" class="btn btn-primary">Ir a publicación de versión</a>
        <?php endif ?>
    <?php endif ?>
<?php endif ?>
<hr>
<table class="table table-hover">
    <tbody>
        <tr>
            <th>Estado del Dataset</th>
            <td>
                <?php if ($dataset->getPublicado()): ?>
                    <span class="label label-success"><i class="icon-ok-circle"></i>Publicado</span>
                <?php else: ?>
                    <span class="label label-warning"><i class="icon-ban-circle"></i>No Publicado</span>
                <?php endif ?>
            </td>
            <?php if ($this->user->hasRol('mantencion')): ?>
                <td nowrap>&nbsp;</td>
            <?php endif ?>
        </tr>
        <tr>
            <th width="15%">Título</th>
            <td><?php echo $dataset->getTitulo(); ?></td>
            <?php if ($this->user->hasRol('mantencion')): ?>
                <td>
                    <?php echo $dataset->getBtnReporteAsociadoCampo('titulo'); ?>
                </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?php echo $dataset->getDescripcion(); ?></td>
            <?php if ($this->user->hasRol('mantencion')): ?>
                <td>
                    <?php echo $dataset->getBtnReporteAsociadoCampo('descripcion'); ?>
                </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Institución</th>
            <td><?php echo $dataset->getServicio()->getNombre(); ?></td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('servicio_codigo'); ?>
            </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Licencia</th>
            <td><?php echo $dataset->getLicencia()->getNombre(); ?></td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('licencia_id'); ?>
            </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Categorías</th>
            <td>
                <?php
                    foreach ($dataset->getCategorias() as $key => $categoria){
                        $a_categorias[] = $categoria->getNombre();
                    }
                    echo isset($a_categorias)?implode(', ', $a_categorias):'No hay categorías asociadas al Dataset';
                ?>
            </td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('categorias'); ?>
            </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Etiquetas</th>
            <td>
            <?php
                foreach ($dataset->getTags() as $key => $tag){
                    $a_tags[] = $tag->getNombre();
                }
                echo isset($a_tags)?implode(', ', $a_tags):'No hay etiquetas asociadas al Dataset';
            ?>
            </td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('tags'); ?>
            </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Frecuencia actualización</th>
            <td><?php echo $dataset->getFrecuencia(); ?></td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('frecuencia'); ?>
            </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Cobertura Geográfica</th>
            <td>
                <?php
                    foreach ($dataset->getSectores() as $key => $sector){
                        $a_sectores[] = $sector->getNombre().' ('.$sector->getTipo().')';
                    }
                    echo isset($a_sectores)?implode(', ', $a_sectores):'No hay sectores asociadas al Dataset';
                ?>
            </td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('sectores'); ?>
            </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Cobertura Temporal</th>
            <td><?php echo $dataset->getCoberturaTemporal(); ?></td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('cobertura_temporal'); ?>
            </td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Granularidad</th>
            <td><?php echo $dataset->getGranularidad(); ?></td>
            <?php if ($this->user->hasRol('mantencion')): ?>
            <td>
                <?php echo $dataset->getBtnReporteAsociadoCampo('granularidad'); ?>
            </td>
            <?php endif ?>
        </tr>
    </tbody>
</table>
<div class="well">
    <?php if ($this->user->hasRol('mantencion')): ?>
    <?php echo $dataset->getBtnReporteAsociadoCampo('recursos', 'pull-right'); ?>
    <?php endif ?>
    <h4>Recursos</h4>
    <table class="table" id="tabla-recursos">
        <thead>
            <tr>
                <th>URL</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Tamaño</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($dataset->getRecursos())): ?>
                <?php foreach ($dataset->getRecursos() as $key => $recurso){ ?>
                    <tr id="recurso-<?php echo $recurso->getId(); ?>">
                        <td><a target="_blank" href="<?php echo $recurso->getUrl(); ?>"><?php echo $recurso->getUrl(); ?></a></td>
                        <td><?php echo $recurso->getDescripcion(); ?></td>
                        <td>
                            <span class="label label-warning"><?php echo mimeHelper::get_mime_name($recurso->getMime()); ?></span>
                        </td>
                        <td><?php echo $recurso->getSize(); ?></td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <th style="text-align:center" colspan="4">No se han encontrado Recursos asociados a este dataset.</th>
                </tr>            
            <?php endif ?>
        </tbody>
    </table>
</div>
<div class="well">
    <?php if ($this->user->hasRol('mantencion')): ?>
    <?php echo $dataset->getBtnReporteAsociadoCampo('documentos', 'pull-right'); ?>
    <?php endif ?>
    <h4>Documentos</h4>
    <table class="table" id="tabla-documentos">
        <thead>
            <tr>
                <th>URL</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Tamaño</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($dataset->getDocumentos())): ?>
                <?php foreach ($dataset->getDocumentos() as $key => $documento){ ?>
                    <tr id="documento-<?php echo $documento->getId(); ?>">
                        <td><a target="_blank" href="<?php echo $documento->getUrl(); ?>"><?php echo $documento->getUrl(); ?></a></td>
                        <td><?php echo $documento->getTitulo(); ?></td>
                        <td><?php echo $documento->getDescripcion(); ?></td>
                        <td>
                            <span class="label label-warning"><?php echo mimeHelper::get_mime_name($documento->getMime()); ?></span>
                        </td>
                        <td><?php echo $documento->getSize(); ?></td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <th style="text-align:center" colspan="5">No se han encontrado Documentos asociados a este dataset.</th>
                </tr>            
            <?php endif ?>
        </tbody>
    </table>
</div>