<div class="span12">
    <div class="row-fluid">
        <div class="span8">
            <h2 class="aplicaciones">Aplicaciones</h2>
        </div>
        <div class="span4 padding15">
            <form class="form-search" id="formFiltrarPor" action="<?php echo current_url(); ?>" method="GET">
                <label for="filterby">Filtrar por</label>
                <select name="filterby" id="filterby" data-auto-submit="change" data-submit-form="formFiltrarPor">
                    <option value="">Todas</option>
                    <option value="publica"<?php echo $filterby=='publica'?' selected="selected"':''; ?>><?php echo $this->lang->line('app_acceso_publicas'); ?></option>
                <option value="privada"<?php echo $filterby=='privada'?' selected="selected"':''; ?>><?php echo $this->lang->line('app_acceso_privadas'); ?></option>
                </select>
            </form>
      </div>
    </div>
    <?php echo widgetHelper::compartirRedesSociales(); ?>
    <div class="cont-aplicaciones">
    <?php foreach ($aplicaciones as $key => $aplicacion){ ?>
        <div class="item-aplicacion app-<?php echo $aplicacion->getAcceso(); ?>">
            <div class="row-fluid">
                <div class="span10">
                    <h3><?php echo $aplicacion->getNombre(); ?></h3>
                    <p class="autor"><?php echo $aplicacion->getAutor(); ?></p>
                    <p><?php echo $aplicacion->getDescripcion(); ?></p>
                    <p>
                        <a href="<?php echo $aplicacion->getUrl(); ?>" target="_blank"><?php echo $aplicacion->getUrl(); ?></a>
                    </p>
                </div>
                <div class="span2 <?php echo $aplicacion->getPlataforma(); ?>">&nbsp;<?php echo $this->lang->line('app_plataforma_'.$aplicacion->getPlataforma()); ?></div>
            </div>
        </div>        
    <?php } ?>
    </div>
    <?php echo $pagination; ?>
</div>
