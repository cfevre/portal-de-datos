<form method="post" action="<?php echo $formAction; ?>" id="form-reporte" class="form-horizontal">
    <legend>Reporte para el Dataset: <?php echo $reporte->getDataset()->getTitulo(); ?></legend>
    <div class="messages"></div>
    <div class="control-group">
        <div class="control-label">
            <label for="tipo_reporte_id">Tipo de reporte</label>
        </div>
        <div class="controls">
            <select  class="input-xxlarge" name="tipo_reporte_id" id="tipo_reporte_id">
                <?php foreach ($tiposReporte as $key => $tipoReporte){ ?>
                    <?php $selected = ($reporte->getTipoReporte() === $tipoReporte)?'selected="selected"':''; ?>
                    <option <?php echo $selected; ?> value="<?php echo $tipoReporte->getId(); ?>"><?php echo $tipoReporte->getTitulo(); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="estado">Estado</label>
        </div>
        <div class="controls">
            <select  class="input-xxlarge" name="estado" id="estado">
                <?php foreach ($reporte->getTiposDeEstado() as $key => $estado){ ?>
                    <?php $selected = (intval($reporte->getEstado()) === intval($key))?'selected="selected"':''; ?>
                    <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $estado; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <?php if ($user->hasRol('mantencion')): ?>
        <?php if ($reporte->getNombre()): ?>
            <div class="control-group">
                <div class="control-label">
                    <label>Nombre</label>
                </div>
                <div class="controls">
                    <span><?php echo $reporte->getNombre(); ?></span>
                </div>
            </div>
        <?php endif ?>
        <?php if ($reporte->getEmail()): ?>
            <div class="control-group">
                <div class="control-label">
                    <label>Email</label>
                </div>
                <div class="controls">
                    <span><?php echo $reporte->getEmail(); ?></span>
                </div>
            </div>
        <?php endif ?>
    <?php endif ?>
    <div class="control-group">
        <div class="control-label">
            <label for="comentarios">Comentarios</label>
        </div>
        <div class="controls">
            <textarea name="comentarios" id="comentarios" class="redactor-content" data-redactor-buttons="link"><?php echo $reporte->getComentarios(); ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?php echo $referer?$referer:site_url('backend/reporte/dataset/'.$dataset->getId()); ?>" class="btn">Cancelar</a>
        </div>
    </div>
    <input type="hidden" id="reporte_id" name="reporte_id" value="<?php echo $reporte->getId(); ?>">
    <input type="hidden" id="dataset_id" name="dataset_id" value="<?php echo $reporte->getDataset()->getId(); ?>">
    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->getId(); ?>">
    <input type="hidden" id="origen_publico" name="origen_publico" value="<?php echo $reporte->getOrigenPublico(); ?>">
    <input type="hidden" id="nombre" name="nombre" value="<?php echo $reporte->getNombre(); ?>">
    <input type="hidden" id="email" name="email" value="<?php echo $reporte->getEmail(); ?>">
    <input type="hidden" id="referer" name="referer" value="<?php echo urlencode($referer); ?>">
    <input type="hidden" id="aux-estado" name="aux-estado" value="<?php echo $reporte->getEstado(); ?>">
</form>