<div class="home-main">
  <div class="container">
    <div class="rowfluid">
        <div class="span12">
            <div id="myCarousel" class="carousel slide">
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        <div class="active item" data-item="0">
                            <a href="http://abrecl.datos.gob.cl" target="_blank">
                                <img src="<?php echo base_url('assets/img/banner/bnnr_condatos_.png'); ?>" alt="Con Datos" target="_blank">
                            </a>
                        </div>
                        <div class="item" data-item="1">
                            <a href="http://apps.gob.cl/" target="_blank">
                                <img src="<?php echo base_url('assets/img/banner/bnnr_datos_apps.png'); ?>" alt="Guía rápida de publicación" target="_blank">
                            </a>
                        </div>
                        <div class="item" data-item="2">
                            <a href="<?php echo site_url('datasets'); ?>">
                                <img src="<?php echo base_url('assets/img/banner/slide-1.jpg'); ?>" alt="Datos.gob.cl">
                            </a>
                        </div>
                    </div>
                    <!-- Carousel nav -->
                    <div class="cont-carrusel-control left">
                        <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                    </div>
                    <div class="cont-carrusel-control right">
                        <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
                    </div>
                    <ul class="cont-carrusel-markers">
                        <li class="marker active" data-item="0"><a href="#">1</a></li>
                        <li class="marker" data-item="1"><a href="#">2</a></li>
                        <li class="marker" data-item="2"><a href="#">3</a></li>
                    </ul>
                </div>
        </div>
    </div>
    <div class="row-fluid">
    	<div class="span12">
	    	<?php echo widgetHelper::catalogosTop(true, 8); ?>
    	</div> 
    </div>
    <!--
    <div class="row-fluid">
        <div class="span12">
            <?php //echo widgetHelper::junarDestacados(); ?>
        </div>
    </div>
    -->
    <div class="row-fluid">
    	<div class="span8">
    		<?php echo widgetHelper::categoriasConMasDatasets(18); ?>
    	</div>
    </div>
  </div>
</div>