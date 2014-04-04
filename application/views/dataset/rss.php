<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
	<channel>
	<title>Catálogo de Datos</title>
	<link><?php echo site_url(); ?></link>
	<description>Acceso a datos públicos generados tanto por el gobierno como por otros organismos del Estado.</description>
	<?php foreach ($datasets as $key => $dataset){ ?>
        <?php
            if(gettype($dataset)=='array'){
                $total_descargas = $dataset['total_descargas'];
                $dataset = $dataset[0];
            }
        ?>
	<item>
	  <title><?php echo $dataset->getTitulo(); ?></title>
	  <link><?php echo site_url('datasets/ver/'.$dataset->getDatasetMaestro()->getId()); ?></link>
	  <author><?php echo $dataset->getServicio()->getNombre(); ?></author>
	  <description><![CDATA[<?php echo $dataset->getDescripcion(); ?>]]></description>
      <pubDate><?php echo $dataset->getDatasetMaestro()->getPrimeraVersionPublicada()->getCreatedAt()->format('D, d M Y H:i:s O'); ?></pubDate>
      <category><?php echo $dataset->getCategoriasString(); ?></category>
      <?php if (isset($total_descargas)): ?>
          <totalDescargas><?php echo $total_descargas; ?></totalDescargas>
      <?php endif ?>
	  </item>
	<?php } ?>
	</channel>
</rss>