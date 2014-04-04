<form action="<?php echo site_url('backend/servicio/migrar'); ?>" method="post" id="form-migracion-servicio">
    <div class="messages"></div>
    <div class="control-group">
        <div class="control-label">
            <label for="url"><strong>Servicio Origen</strong></label>
        </div>
        <div class="controls">
            <?php echo $servicio->getNombre(); ?>
            <input type="hidden" name="codigo_origen" id="codigo_origen" value="<?php echo $servicio->getCodigo(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="url"><strong>Servicio Destino</strong></label>
        </div>
        <div class="controls">
            <select name="codigo_destino" id="codigo_destino" class="chzn-select input-xxlarge">
                <option value="">- Todos -</option>
                <?php foreach ($servicios as $key => $servicioCombo){ ?>
                    <option value="<?php echo $servicioCombo->getCodigo(); ?>"><?php echo $servicioCombo->getNombre(); ?></option>
                <?php } ?>
            </select>
        </div>
        <br/>
        <div class="controls">
            <div class="control-label">
                <label class="checkbox pull-left popover-icon" for="actualizar_servicio_oficial" data-placement="right" data-trigger="hover" data-original-title="Servicio Oficial" data-content="Se utilizará el servicio de destino como servicio oficial para futuras cargas mediante la API"><input type="checkbox" value="s" name="actualizar_servicio_oficial" id="actualizar_servicio_oficial"/><i class="icon-question-sign"></i> Actualizar el servicio oficial</label>
                <div class="clearfix"></div>
             </div>
        </div>
    </div>
    <div class="form-actions">
        <button class="btn btn-primary">Migrar</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    </div>
    <div class="control-group">
        <h4>Datasets a migrar:</h4>
        <?php if ($migracionCompleta): ?>
            <div class="alert alert-info">
                Se migrarán todos los datasets del servicio de origen
            </div>
        <?php else: ?>
            <?php if (!count($datasets)): ?>
                <p>No se han seleccionado datasets para migrar.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="80">Codigo</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datasets as $dataset): ?>
                            <tr>
                                <td>
                                    <?php echo $dataset->getId(); ?>
                                    <input type="hidden" name="dataset[]" value="<?php echo $dataset->getId(); ?>"/>
                                </td>
                                <td><?php echo $dataset->getTitulo(); ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        <?php endif ?>
    </div>
    <div class="clearfix"></div>
    <input type="hidden" name="migracion-completa" value="<?php echo $migracionCompleta; ?>"/>
</form>