<div class="cont-widget">
<?php $i = 0; ?>
<?php if($showTitle){ ?>
    <h2 class="catalogo-datos">Catálogo<small>&nbsp;Datasets publicados: <strong><?php echo number_format($ndatasets,0,',','.'); ?></strong></small></h2>   
<?php } ?>
<div id="widget-catalogos-top">
    <ul id="catalogo-tabs" class="nav nav-pills nav-tabs">
        <li class="active"><a href="#dataset-recientes" data-toggle="tab">Recientes</a></li>
        <li><a href="#dataset-masvistos" data-toggle="tab">Más vistos</a></li>
        <li><a href="#dataset-masdescargados" data-toggle="tab">Más descargados</a></li>
    </ul>
    <div id="catalogo-tabs-content" class="tab-content">
        <?php foreach ($catalogos as $nombre_catalogo => $catalogo){ ?>
            <div id="dataset-<?php echo $nombre_catalogo; ?>" class="tab-pane<?php echo $i==0?' active':''; ?>">
                <div class="row-fluid">
                <?php foreach ($catalogo as $dataset_key => $dataset){ ?>
                    <?php
                        switch ($nombre_catalogo) {
                            case 'masvistos':
                                $extra = $dataset['vistas'];
                                $dataset = $dataset[0];
                                break;
                            case 'masdescargados':
                                $extra = $dataset['descargas'];
                                $dataset = $dataset[0];
                                break;
                            default:
                                $extra = null;
                                break;
                        }
                    ?>
                    <div class="dataset-container span3">
                        <div class="dataset-container-front">
                            <?php if ($extra): ?>
                                <div class="extra-info-dataset">
                                    <strong><?php echo $nombre_catalogo=='masvistos'?'Visitas':'Descargas'; ?>: </strong><span class="label label-important"><?php echo $extra; ?></span>
                                </div>
                            <?php endif ?>
                            <div class="dataset-body">
                                <h3>
                                    <a href="<?php echo site_url('datasets/ver/'.$dataset->getDatasetMaestro()->getId()); ?>"><?php echo stringsHelper::truncate_words($dataset->getTitulo(), 10); ?></a>
                                </h3>
                                <div class="dataset-inner">
                                    <div class="col">
                                        <h4>Fuente:</h4>
                                        <p><a href="<?php echo site_url('servicios/ver/'.$dataset->getServicio()->getCodigo()); ?>"><?php echo $dataset->getServicio()->getNombre(); ?></a></p>
                                    </div>
                                    <div class="col">
                                        <h4>Categorías:</h4>
                                        <p>
                                            <?php foreach ($dataset->getCategorias() as $key => $categoria){ ?>
                                                <span class="label label-warning"><?php echo $categoria->getNombre(); ?></span>    
                                                <?php if($key >= 3) break; ?>
                                            <?php } ?>
                                        </p>
                                        <h4>Formatos:</h4>
                                        <p>
                                            <?php foreach ($dataset->formatosDisponibles() as $formato){ ?>
                                                <span class="label label-warning"><?php echo mimeHelper::get_mime_name($formato); ?></span>     
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="cont-icon-action" href="#">
                                <i class="icon-plus-sign">&nbsp;</i>
                            </div>
                        </div>
                        <div class="dataset-container-back">
                            <div class="dataset-body">
                                <p><strong>Fecha de publicación</strong></p>
                                <p><?php echo strftime('%e de %B del %Y',$dataset->getUpdatedAt()->getTimestamp()); ?></p>
                                <p><strong>Descripción:</strong></p>
                                <p><?php echo stringsHelper::truncate_words($dataset->getDescripcion(), 30); ?></p>
                            </div>
                            <div class="cont-icon-action" href="#">
                                <i class="icon-remove-sign icon-white">&nbsp;</i>
                            </div>
                        </div>
                    </div>
                    <?php if(!(($dataset_key+1)%4)){ ?>
                </div>
                        <div class="row-fluid">
                    <?php } ?>
                <?php } ?>
                        </div>
            </div>
            <?php $i++;?>
        <?php } ?>
    </div>
</div>
</div>