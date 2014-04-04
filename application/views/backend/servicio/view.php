<h3>Servicio: <?php echo $servicio->getNombre(); ?></h3>
<table class="table table-hover">
    <tbody>
        <tr>
            <th width="15%">Nombre</th>
            <td><?php echo $servicio->getNombre(); ?></td>
        </tr>
        <tr>
            <th>Codigo</th>
            <td><?php echo $servicio->getCodigo(); ?></td>
        </tr>
        <tr>
            <th>Sigla</th>
            <td><?php echo $servicio->getSigla(); ?></td>
        </tr>
        <tr>
            <th>Url</th>
            <td><?php echo $servicio->getUrl(); ?></td>
        </tr>
        <tr>
            <th>Es Oficial</th>
            <td>
                <?php if ($servicio->getOficial()): ?>
                    <span class="label label-mini label-info">Oficial</span>
                <?php else: ?>
                    <span class="label label-mini label-warning">No Oficial</span>
                <?php endif ?>
            </td>
        </tr>
        <tr>
            <th>Estado</th>
            <td>
                <?php if(!$servicio->getPublicado()){ ?>
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
        </tr>
    </tbody>
</table>
<h4>Datasets Asociados</h4>
<form class="form form-horizontal" id="form-seleccionar-todos" action="">
    <label for="seleccionar-todos" class="checkbox"><input type="checkbox" value="s" name="seleccionar-todos" id="seleccionar-todos"> Seleccionar todos</label>
    <?php if ($pagination): ?>
        <div class="cont-seleecionar-todos-paginas"><label for="seleccionar-todos-paginas" class="checkbox"><input type="checkbox" value="s" name="seleccionar-todos-paginas" id="seleccionar-todos-paginas"> Seleccionar todos incluyendo las otras paginas.</label></div>
    <?php endif ?>
    <h6>Acciones masivas</h6>
    <button class="btn btn-primary" id="migrar-datasets" value=""/><i class="icon-share-alt icon-white"></i> Migrar</button>
    <button class="btn btn-success btn-accion-ajax" id="publicar-datasets" data-publicar="1" value=""/><i class="icon-ok-circle icon-white icon-loader-disabled"></i> Publicar</button>
    <button class="btn btn-warning btn-accion-ajax" id="despublicar-datasets" data-publicar="0" value=""/><i class="icon-ban-circle icon-white icon-loader-disabled"></i> Despublicar</button>
    <p class="mensaje-acciones"></p>
    <hr/>
    <table class="table table-datasets-servicio">
        <thead>
            <tr>
                <th width="20">&nbsp;</th>
                <th>Nombre</th>
                <th>Publicado</th>
                <th>N° Recursos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datasets as $dataset): ?>
            <tr id="fila-datasets-<?php echo $dataset->getId(); ?>">
                <td>
                    <input type="checkbox" class="check-dataset-servicio" value="<?php echo $dataset->getId(); ?>" id="dataset-<?php echo $dataset->getId(); ?>" name="dataset[]"/>
                </td>
                <td>
                    <a href="<?php echo site_url('backend/dataset/view/'.$dataset->getId()); ?>"><?php echo $dataset->getTitulo(); ?></a>
                </td>
                <td class="cont-label-publicacion">
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
                </td>
                <td>
                    <?php echo $dataset->getRecursos()->count(); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><?php echo $pagination; ?></td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" value="<?php echo $servicio->getCodigo(); ?>" id="codigo-servicio" name="codigo-servicio"/>
</form>
