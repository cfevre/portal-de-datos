<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST" id="formTipoReporte">
    <fieldset>
        <legend><?php echo $tipoReporte->getId()?'Edición Tipo reporte ['.$tipoReporte->getId().']':'Nuevo Tipo reporte'; ?></legend>
        <div class="control-group">
            <div class="control-label">
                <label for="titulo">Título</label>
            </div>
            <div class="controls">
                <input type="text" class="input-block-level" name="titulo" id="titulo" value="<?php echo $tipoReporte->getTitulo(); ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="comentario_sugerido">Comentario Sugerido</label>
            </div>
            <div class="controls">
                <textarea name="comentario_sugerido" id="comentario_sugerido" class="redactor-content" data-redactor-buttons="link"><?php echo $tipoReporte->getComentarioSugerido(); ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="grado_reporte_id">Grado del Reporte</label>
            </div>
            <div class="controls">
                <select name="grado_reporte_id" id="grado_reporte_id">
                    <?php foreach ($gradosReporte as $key => $gradoReporte){ ?>
                        <option value="<?php echo $gradoReporte->getId(); ?>" <?php echo $gradoReporte===$tipoReporte->getGradoReporte()?'selected="selected"':''; ?>><?php echo $gradoReporte->getNombre(); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="campo_dataset">Campo Dataset</label>
            </div>
            <div class="controls">
                <select  class="input-medium" name="campo_dataset" id="campo_dataset">
                    <option value=""> - Ninguno - </option>
                    <?php foreach ($camposDataset as $campoDataset => $nombreCampoDataset){ ?>
                        <?php $selected = $tipoReporte->getCampoDataset() === $campoDataset ? 'selected="selected"':''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $campoDataset; ?>"><?php echo $nombreCampoDataset; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="publico">Acceso público</label>
            </div>
            <div class="controls">
                <input type="checkbox" value="1" id="publico" name="publico" <?php echo $tipoReporte->getPublico()?'checked="checked"':''; ?>>
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?php echo $tipoReporte->getId(); ?>">
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="<?php echo site_url('backend/tiporeporte'); ?>">Cancelar</a>
        </div>
    </fieldset>
</form>