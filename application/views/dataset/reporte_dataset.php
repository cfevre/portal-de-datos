<div class="row-fluid">
    <div class="span6 pull-right">
        <button class="btn btn-warning btn-muestra-formulario-denuncia">¿Hay algún problema con este dataset?</button>
    </div>
    <div class="span12">
        <div class="cont-formulario-denuncia">
            <hr>
            <div class="well wrapper-formulario-denuncia">
                <form action="<?php echo site_url('reporte/ajax_enviar_reporte'); ?>" id="formulario-denuncia" class="form form-vertical">
                    <div class="form-vertical">
                        <legend>¿Qué debemos mejorar?</legend>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="tipo_reporte_id">Razón del problema</label>
                            </div>
                            <div class="controls">
                                <select name="denuncia-tipo_reporte_id" id="tipo_reporte_id">
                                    <?php foreach ($tiposReporte as $key => $tipoReporte){ ?>
                                        <option value="<?php echo $tipoReporte->getId(); ?>"><?php echo $tipoReporte->getTitulo(); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <label for="denuncia-comentarios">Comentarios</label>
                            </div>
                            <div class="controls">
                                <textarea name="denuncia-comentarios" id="denuncia-comentarios" class="input-block-level" rows="6"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal row-fluid">
                        <div class="span6">
                            <p>Si deseas que te contactemos, ingresa la siguiente información opcional.</p>
                            <label for="denuncia-nombre">Nombre</label>
                            <input type="text" class="input-block-level" name="denuncia-nombre" id="denuncia-nombre" value="">
                                <label for="denuncia-email">Email</label>
                            <input type="email" class="input-block-level" name="denuncia-email" id="denuncia-email" value="">
                        </div>
                        <div class="span6">
                            <br>
                            <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LdPI9kSAAAAADIKGtUlaNYYcH55_4eviM0zwxc3"></script>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary pull-right">Enviar</button>
                    <div class="mensajes span8"></div>
                    <input type="hidden" id="denuncia-origen_publico" name="denuncia-origen_publico" value="1">
                    <input type="hidden" id="denuncia-dataset_id" name="denuncia-dataset_id" value="<?php echo $dataset->getDatasetMaestro()->getId(); ?>">
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="mensaje-gracias alert alert-success">
                <p>Gracias por ayudarnos a mejorar los datos abiertos.</p>
            </div>
        </div>
    </div>
</div>