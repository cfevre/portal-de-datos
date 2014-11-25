<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title>Solicitudes</title>
		<link><?php echo site_url('participa'); ?></link>
		<description>Descripción de la solicitud</description>
		<?php foreach ($participaciones as $key => $participacion){ ?>
		<item>
		  <title><?php echo $participacion->getTitulo(); ?></title>
		  <guid><?php echo site_url('participa/ver/'.$participacion->getId()); ?></guid>
		  <atom:link href="<?php echo site_url('participa/ver/'.$participacion->getId()); ?>" rel="self" type="application/rss+xml" />
		  <description><![CDATA[<?php echo $participacion->getMensaje(); ?>]]></description>
	      <pubDate><?php echo $participacion->getCreatedAt()->format(DATE_RSS); ?></pubDate>
	      <category><?php echo $participacion->getCategoria(); ?></category>
		 </item>
		<?php } ?>
	</channel>
</rss>