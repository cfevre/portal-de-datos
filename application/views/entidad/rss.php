<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
    <channel>
    <title>Datasets publicados por Institución</title>
    <link><?php echo current_url(); ?></link>
    <description>Se muestra el total de datasets publicados en cada institución del portal de Datos.gob.cl</description>
    <?php foreach ($entidades as $key => $entidad){ ?>
        <item>
      <title><?php echo $entidad[0]->getNombre(); ?></title>
      <link><?php echo site_url('categorias/ver/'.$entidad[0]->getCodigo()); ?></link>
      <description><?php echo $entidad['ndatasets']; ?></description>
      </item>
    <?php } ?>
    </channel>
</rss>