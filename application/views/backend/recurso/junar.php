<form action="<?php echo site_url('backend/recurso/enviarjunar/'.$vista_junar->getId()); ?>" id="form-recurso-junar" method="post">
    <div class="messages"></div>
    <div class="control-group">
        <div class="control-label">
            <label for="url">Url recurso</label>
        </div>
        <div class="controls">
            <a target="_blank" href="<?php echo $vista_junar->getSource(); ?>"><?php echo stringsHelper::truncate_string($vista_junar->getSource(), 80); ?></a>
            <input type="hidden" name="source" value="<?php echo $vista_junar->getSource(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="title">Título</label>
        </div>
        <div class="controls">
            <input type="text" class="input-block-level" name="title" id="title" value="<?php echo $vista_junar->getTitle(); ?>">
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="category">Categoría</label>
        </div>
        <div class="controls">
            <?php $categoriasJunar = array("Vivienda", "Salud", "General", "Educación", "Finanzas", "Medio Ambiente"); ?>
            <select  class="input-medium" name="category" id="category">
                <option value="">- Seleccione -</option>
                <?php foreach ($categoriasJunar as $categoriaJunar): ?>
                    <option <?php echo $vista_junar->getCategory() == $categoriaJunar ? 'selected="selected"' : ''; ?> value="<?php echo $categoriaJunar; ?>"><?php echo $categoriaJunar; ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="tags">Etiquetas</label>
        </div>
        <div class="controls">
            <ul class="nav nav-pills tag-list">
                <?php foreach (explode(',', $vista_junar->getTags()) as $tag){ ?>
                    <li><?php echo $tag; ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="table_id">Hoja de Documento</label>
        </div>
        <div class="controls">
            <input type="number" class="input-small" name="table_id" id="table_id" value="<?php echo $vista_junar->getTableId() == '' ? 0 : $vista_junar->getTableId(); ?>"/>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="control-group">
        <div class="control-label">
            <label for="description">Descripción</label>
        </div>
        <div class="controls">
            <textarea name="description" class="input-block-level" rows="3" id="description"><?php echo strip_tags($vista_junar->getDescription()); ?></textarea>
        </div>
    </div>
    <input type="hidden" name="recurso_id" value="<?php echo $vista_junar->getRecurso()->getId(); ?>"/>
</form>
<div class="modal-footer">
    <button class="btn btn-primary" data-ajax-form-id="form-recurso-junar" data-ajax-command="guardarvistajunar" data-ajax-controller="recurso" data-disable="true" data-ajax-params="<?php echo $vista_junar->getId(); ?>">Guardar</button>
    <button class="btn btn-primary" data-ajax-form-id="form-recurso-junar" data-ajax-command="enviarjunar" data-ajax-controller="recurso" data-disable="true" data-ajax-params="<?php echo $vista_junar->getId(); ?>">Enviar</button>
</div>