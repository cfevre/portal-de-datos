<div class="span8">
<article class="post" itemscope itemtype="http://schema.org/WebPage">
    <input type="hidden" value="<?php echo $dataset->getDatasetMaestro()->getId(); ?>" id="maestroId" name="maestroId">
    <section class="body">
        <div id="ficha">
        		<h2><?php echo $dataset->getTitulo(); ?></h2>
        		<div class="cont-rating-ficha">
        			<span>Valoración:</span> <?php echo widgetHelper::rating($dataset); ?>
        		</div>
        		<?php echo widgetHelper::compartirRedesSociales(); ?>
            <div class="ratingDataset" itemscope itemtype="http://schema.org/Rating">
                <meta itemprop="ratingValue" content="<? echo $dataset->getDatasetMaestro()->getRating(); ?>" />
            </div>
            <div class="row-fluid">
	            <div class="span6" itemprop="author" itemscope itemtype="http://schema.org/GovernmentOrganization">
	                <h4>Institución</h4>
	                <p class="well">
	                    <a href="<?= site_url('servicios/ver/' . $dataset->getServicio()->getCodigo()) ?>"><span itemprop="name"><?= $dataset->getServicio()->getNombre(); ?></span></a>
	                </p>
	            </div>
	            <div class="span6">
	                <h4>Fecha de Publicación</h4>
	                <p class="well"><time itemprop="datePublished" datetime="<?= $dataset->getDatasetMaestro()->getPublicadoAt()->format('Y-m-d H:i:s') ?>"><?= strftime('%e de %B del %Y a las %R', $dataset->getDatasetMaestro()->getPublicadoAt()->getTimestamp()) ?></time></p>
	            </div>
            </div>
            <h4>Descripción</h4>
            <div class="well truncate" itemprop="description">
                <?= nl2br($dataset->getDescripcion()) ?>
            </div>

            <h4>Categorías</h4>
            <p class="well" itemscope itemtype="http://www.schema.org/CollectionPage">
                <?php
                $etiquetas = array();
                foreach ($dataset->getCategorias() as $c) {
                    $etiquetas[] = '<a itemprop="relatedLink" href="' . site_url('categorias/ver/' . $c->getId()) . '">' . $c->getNombre() . '</a>';
                }
                echo implode(', ', $etiquetas);
                ?>
            </p>

            <h4>Recursos <i class="icon-question-sign popover-icon" data-content="Recursos para descargar." data-trigger="hover" data-original-title="Recursos"></i></h4>
                <h5>Actualizados el <span itemprop="lastReviewed"><?= strftime('%e de %B del %Y', $dataset->getPublicadoAt() ? $dataset->getPublicadoAt()->getTimestamp() : $dataset->getUpdatedAt()->getTimestamp()) ?></span></h5>
            <table class="recursos table table-bordered table-hover table-striped">
              <?php foreach ($recursos as $r): ?>
                <tr>
                    <td><a target="_blank" href="<?= site_url('recursos/download/' . $r[0]->getCodigo()) ?>"><?= $r[0]->getDescripcion() != "" ? $r[0]->getDescripcion() : 'Ver recurso'; ?></a></td>
                    <td><a target="_blank" href="<?= site_url('recursos/download/' . $r[0]->getCodigo()) ?>"><span class="label label-warning"><?php echo mimeHelper::get_mime_name($r[0]->getMime()); ?></span></a></td>
                    <td><?= number_format($r[0]->getSize() / 1000, 0, ',', '.') ?> KB</td>
                    <td><? echo intval($r['totaldescargas']); ?> Hits</td>
                </tr>
              <?php endforeach; ?>
            </table>
            <div class="cont-recursos-junar">
            	<h4>Otros Recursos</h4>
            	<img src="<?php echo base_url('assets/img/loader.gif'); ?>" alt="Loading" class="loader-recursos">
            	<table id="tabla-recursos-junar" class="table table-bordered table-hover">
            		<thead>
	                <tr>
	                  <td colspan="3">Recurso</td>
	                </tr>
	                <tr>
	                  <td>Título</td>
	                  <td>Descripción</td>
	                  <td>Tags</td>
	                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <h4>Documentación Asociada</h4>
            <div class="well">
                <?php if ($dataset->getDocumentos()->count()): ?>
                    <ul class="unstyled">
                        <?php foreach ($dataset->getDocumentos() as $doc): ?>
                            <li>
                                <p>
                                    <a target="_blank" href="<?= $doc->getUrl() ?>"><?= $doc->getTitulo() ?></a>
                                    <a target="_blank" href="<?= $doc->getUrl() ?>" class="label label-warning">
                                    	<?php echo $doc->getMime(); ?>
                                    </a>
                                </p>
                                <p><?= $doc->getDescripcion() ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    No hay documentación asociada disponible
                <?php endif; ?>
            </div>

            <div class="row-fluid">
	           <div class="span6">

	                <h4>Etiquetas</h4>
	                <p itemprop="keywords" class="well">
	                    <?php
	                    $etiquetas = array();
	                    foreach ($dataset->getTags() as $t) {
	                        $etiquetas[] = '<a class="tag label label-well" href="' . site_url('tags/ver/' . $t->getId()) . '">' . $t->getNombre() . '</a>';
	                    }
	                    echo implode(' ', $etiquetas);
	                    ?>
	                </p>

	                <h4>Licencia</h4>
	                <p class="well"><a target="_blank" href="<?= $dataset->getLicencia()->getUrl() ?>"><?= $dataset->getLicencia()->getNombre() ?></a></p>


	                <h4>id/Dcat</h4>
	                <p class="well">
	                    dataId: <?= $dataset->getDatasetMaestro()->getId() ?><br />
	                    <a href="<?= site_url('datasets/rdf/' . $dataset->getDatasetMaestro()->getId()) ?>">Descargar DCAT/RDF</a>
	                </p>

	                <h4>Estadística de descargas</h4>
	                <div id="chartDescargas" data-datasetid="<?= $dataset->getId() ?>" style="width: 100%; height: 200px"></div>

	            </div>
	            <div class="span6">
	                <h4>Última Fecha de Actualización</h4>
	                <p class="well"><?= strftime('%e de %B del %Y', $dataset->getPublicadoAt() ? $dataset->getPublicadoAt()->getTimestamp() : $dataset->getUpdatedAt()->getTimestamp()) ?></p>

	                <h4>Frecuencia de Actualización <span class="help tooltip" title="Describe con que frecuencia se actualiza la wellrmación del Dataset. Por ejemplo: diaria, semanal, mensual o anual.">Ayuda</span></h4>
	                <p class="well"><?= $dataset->getFrecuencia() ? $dataset->getFrecuencia() : 'n/a' ?></p>

	                <h4>Ubicación Geográfica <span class="help tooltip" title="Corresponde al nombre del área geográfica con la cual se encuentra relacionado el Dataset. En este campo se debe escribir el nombre del país, región o comuna asociada. Por ejemplo: Vitacura (comuna).">Ayuda</span></h4>
	                <p class="well">
	                    <?php
	                    if ($dataset->getSectores()->count()) {
	                        $etiquetas = array();
	                        foreach ($dataset->getSectores() as $t) {
	                            $etiquetas[] = $t->getNombre();
	                        }
	                        echo implode(', ', $etiquetas);
	                    } else {
	                        echo 'n/a';
	                    }
	                    ?>
	                </p>

	                <h4>Granularidad <span class="help tooltip" title="Corresponde al nivel de detalle que presentan los datos del Dataset. Por ejemplo: Provincias, Comunas, Cuadras, etc.">Ayuda</span></h4>
	                <p class="well"><?= $dataset->getGranularidad() ? $dataset->getGranularidad() : 'n/a' ?></p>

	                <h4>Cobertura Temporal <span class="help tooltip" title="Corresponde al periodo de tiempo que tiene asociado al Dataset. Puede ser una fecha exacta o un periodo de años, meses, semanas, días, etc. Por ejemplo: 2011, Enero, 2005 - 2010, etc.">Ayuda</span></h4>
	                <p class="well"><?= $dataset->getCoberturaTemporal() ? $dataset->getCoberturaTemporal() : 'n/a' ?></p>
	            </div>	
            </div>
            <?php echo $this->load->view('dataset/reporte_dataset', array('tipos_reporte' => $tiposReporte, 'dataset' => $dataset)); ?>
            <input type="hidden" name="urlRecursosJunar" id="urlRecursosJunar" value="<?php echo $urlRecursosJunar; ?>">
            <input type="hidden" name="urlVisualizacionesJunar" id="urlVisualizacionesJunar" value="<?php echo $urlVisualizacionesJunar; ?>">
        </div>
    </section>
</article>
</div>
<div class="span4">
    <?php echo widgetHelper::categoriasConMasDatasets(); ?>
    <?php echo widgetHelper::etiquetasPopulares(); ?>
    <div class="cont-widget cont-widget-junar hidden">
        <div class="widget-header">
            <h2 class="dashboard">Visualización</h2>
        </div>
        <div class="widget-content"></div>
    </div>
</div>