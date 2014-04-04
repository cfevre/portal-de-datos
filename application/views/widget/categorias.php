<div class="cont-widget cont-widget-categorias cont-widget-color">
    <div class="widget-header">
        <a href="<?php echo site_url('categorias'); ?>">ver todas</a>
        <h2 class="etiquetas">Categorías</h2>
    </div>
    <div class="widget-content">
        <?php foreach ($categorias as $key => $categoria){ ?>
            <a data-count="<?php echo $categoria['ndatasets']; ?>" href="<?php echo site_url('categorias/ver/'.$categoria[0]->getId()); ?>" class="label label-info"><?php echo $categoria[0]->getNombre(); ?> (<?php echo $categoria['ndatasets']; ?>)</a>
        <?php } ?>
    </div>
</div>