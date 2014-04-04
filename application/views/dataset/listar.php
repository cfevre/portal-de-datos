<div class="span8">
    <div class="row-fluid">
        <div class="span8">
            <h2 class="catalogo">
                <?php echo $list_title; ?>
            </h2>
            <?php if (isset($q)): ?>
                <p class="titulo-resultado">
                    <strong>Resultados para: </strong><span><?php echo htmlentities($q); ?></span>
                </p>
            <?php endif ?>
        </div>
        <div class="span4">
            <form class="form-search" id="formOrdenarPor" action="<?php echo current_url(); ?>" method="GET">
                <?php if (isset($q) && $q): ?>
                    <input type="hidden" name="q" value="<?php echo htmlentities($q); ?>">
                <?php endif ?>
                <label for="orderby">Ordenar por</label>
                <select name="orderby" id="orderby" data-auto-submit="change" data-submit-form="formOrdenarPor">
                    <option value="created_at"<?php echo $orderby=='created_at'?' selected="selected"':''; ?>>Mas nuevos</option>
                    <option value="ndescargas"<?php echo $orderby=='ndescargas'?' selected="selected"':''; ?>>Descargas (Último mes)</option>
                    <option value="rating"<?php echo $orderby=='rating'?' selected="selected"':''; ?>>Evaluaciones</option>
                    <option value="titulo"<?php echo $orderby=='titulo'?' selected="selected"':''; ?>>Título</option>
                </select>
            </form>
        </div>
    </div>
    <?php echo widgetHelper::compartirRedesSociales(); ?>
    <?php if (!$datasets): ?>
        <div class="alert alert-warning">
            No se han encontrado datasets.
        </div>
    <?php else: ?>
        <p>
            <span class="contador">Mostrando <?=$offset+1?> - <?=min($offset+$limit,$total)?> de <?=$total?> resultados</span>
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Formatos</th>
                    <th>Popularidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datasets as $key => $dataset){ ?>
                    <?php
                        if(is_array($dataset)){
                            $total_descargas = $dataset['total_descargas'];
                            $dataset = $dataset[0];
                        }
                    ?>
                    <tr>
                        <td>
                            <h5>
                                <a href="<?php echo site_url('datasets/ver/'.$dataset->getDatasetMaestro()->getId()); ?>">
                                    <?php echo $dataset->getTitulo(); ?>
                                    &nbsp;
                                    <small>(cdataId: <?php echo $dataset->getDatasetMaestro()->getId(); ?>)</small>
                                </a>
                            </h5>
                            <p><?php echo stringsHelper::truncate_words($dataset->getDescripcion(), 100); ?></p>
                            <p class="rutas-servicios">
                                <a href="<?php echo site_url('entidades/ver/'.$dataset->getServicio()->getEntidad()->getCodigo()); ?>"><?php echo $dataset->getServicio()->getEntidad()->getNombre(); ?></a>
                                <span>»</span>
                                <a href="<?php echo site_url('servicios/ver/'.$dataset->getServicio()->getCodigo()); ?>"><?php echo $dataset->getServicio()->getNombre(); ?></a>
                            </p>
                            <p class="fecha-publicacion">
                                Publicado el <?php echo strftime('%e de %B del %Y a las %H:%M', $dataset->getDatasetMaestro()->getPublicadoAt()->getTimestamp()); ?>
                            </p>
                        </td>
                        <td>
                            <?php foreach ($dataset->formatosDisponibles() as $formato){ ?>
                         <span class="label label-warning"><?php echo mimeHelper::get_mime_name($formato); ?></span>     
                  <?php } ?>
                        </td>
              <td style="text-align: center; white-space: nowrap;">
                  <?php echo widgetHelper::rating($dataset); ?>
                  <div class="clearfix"></div>
                <div class="ndescargas">(<? echo $dataset->getDatasetMaestro()->getNdescargas()?$dataset->getDatasetMaestro()->getNdescargas():'sin'; ?> descargas)</div>
              </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
    <?php endif; ?>
</div>
<div class="span4 side-bar">
    <?php echo widgetHelper::categoriasConMasDatasets(); ?>
    <?php echo widgetHelper::etiquetasPopulares(); ?>
    <?php echo widgetHelper::catalogosMasDescargados(10); ?>
    <?php echo widgetHelper::banner('colabora'); ?>
    <?php echo widgetHelper::banner('gobiernoabierto'); ?>
</div>