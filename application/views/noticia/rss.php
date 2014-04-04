<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
<channel>
<title>Catálogo de Datos - Noticias</title>
<link><?php echo site_url('noticias'); ?></link>
<description>Acceso a datos públicos generados tanto por el gobierno como por otros organismos del Estado.</description>
<?php foreach ($noticias as $key => $noticia){ ?>
  <item>
    <title><?php echo $noticia->getTitulo(); ?></title>
    <link><?php echo site_url('noticias/ver/'.$noticia->getId()); ?></link>
    <description><![CDATA[<?php echo $noticia->getResumen(); ?>]]></description>
  </item>	
<?php } ?>
</channel>
</rss>