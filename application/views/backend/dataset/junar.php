<h4 class="pull-right">Dataset: <?php echo $dataset->getTitulo(); ?></h4>
<h3>Envío de Recursos a Junar</h3>
<hr>
<div class="row-fluid main-vistas-junar">
    <div class="span12">
        <h4>Recursos</h4>
        <table class="tabla-recursos table table-striped">
            <thead>
                <tr>
                    <th class="col-recurso">Recurso</th>
                    <th class="col-vistas">Vistas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataset->getRecursos() as $recurso): ?>
                    <tr>
                        <td>
                            <p><?php echo strip_tags($recurso->getDescripcion()); ?></p>
                            <a class="pull-right" target="_blank" href="<?php echo $recurso->getUrl(); ?>"><i class="icon-share"></i> Url recurso</a>
                        </td>
                        <td>
                            <table class="table table-vistas">
                                <thead>
                                    <tr>
                                        <th>
                                            Título
                                        </th>
                                        <th>
                                            Hoja
                                        </th>
                                        <th>
                                            Estado
                                        </th>
                                        <th>
                                            <a href="<?php echo site_url('backend/recurso/crearVistaJunar/'.$recurso->getId()); ?>" class="pull-right btn btn-small btn-primary ajax-modal" data-modal-header="Crear vista para Junar" data-disable="true"><i class="icon-white icon-plus-sign"></i> <strong>Agregar</strong></a>
                                        </th>
                                    </tr>
                                    <tr class="cont-mensajes-ajax">
                                    </tr>
                                </thead>
                                <tbody id="tbody-vistas-recurso-<?php echo $recurso->getId(); ?>">
                                <?php foreach($recurso->getVistasJunar() as $vistaJunar): ?>
                                    <?php echo $this->load->view('backend/recurso/tr_vista_junar', array('vistaJunar' => $vistaJunar));; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>