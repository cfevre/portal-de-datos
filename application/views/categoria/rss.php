<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
    <channel>
    <title>Datasets publicados por Categoría</title>
    <link><?php echo current_url(); ?></link>
    <description>Se muestra el total de datasets publicados en cada categoría del portal de Datos.gob.cl</description>
    <?php foreach ($categorias as $key => $categoria){ ?>
        <item>
        <?php if (!gettype($categoria) == 'array'): ?>
            <title><?php echo $categoria[0]->getNombre(); ?></title>
            <link><?php echo site_url('categorias/ver/'.$categoria[0]->getId()); ?></link>
            <description><?php echo $categoria['ndatasets']; ?></description>
        <?php endif ?>
        <?php if (isset($datasets)): ?>
            <title><?php echo $categoria->getNombre(); ?></title>
            <link><?php echo site_url('categorias/ver/'.$categoria->getId()); ?></link>
            <description>
                <?php foreach ($datasets[$categoria->getId()] as $dataset): ?>
                    <dataset>
                        <titulo><?php echo $dataset[0]->getTitulo(); ?></titulo>
                        <descargas><?php echo $dataset['cantdescargas']; ?></descargas>
                    </dataset>
                <?php endforeach ?>
            </description>
        <?php endif ?>
        </item>
    <?php } ?>
    </channel>
</rss>