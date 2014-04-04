<div class="span8">
    <h2 class="catalogo">Categorías</h2>
    <div class="cont-categorias">
        <?php foreach ($categorias as $key => $categoria){ ?>
            <div class="item-categoria">
                <a href="<?php echo site_url('categorias/ver/'.$categoria[0]->getId()); ?>">
                    <h4><?php echo $categoria[0]->getNombre(); ?> (<?php echo $categoria['ndatasets']; ?>)</h4>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
<div class="span4 side-bar">
    <?php echo widgetHelper::etiquetasPopulares(); ?>
    <?php echo widgetHelper::banner('colabora'); ?>
    <?php echo widgetHelper::banner('gobiernoabierto'); ?>
</div>