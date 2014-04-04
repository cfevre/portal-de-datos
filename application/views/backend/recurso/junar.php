<form action="<?php echo site_url('backend/recurso/enviarjunar/'.$recurso->getId()); ?>" id="form-recurso-junar" method="post">
    <div class="messages"></div>
    <div class="control-group">
        <div class="control-label">
            <label for="url">Url recurso</label>
        </div>
        <div class="controls">
            <a target="_blank" href="<?php echo $recurso->getUrl(); ?>"><?php echo $recurso->getUrl(); ?></a>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="title">Título</label>
        </div>
        <div class="controls">
            <input type="text" class="input-block-level" name="title" id="title" value="<?php echo $recurso->getDataset()->getTitulo(); ?>">
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="category">Categoría</label>
        </div>
        <div class="controls">
            <select  class="input-medium" name="category" id="category">
                <option value="">- Seleccione -</option>
                <option value="Vivienda">Vivienda</option>
                <option value="Salud">Salud</option>
                <option value="General">General</option>
                <option value="Educación">Educación</option>
                <option value="Finanzas">Finanzas</option>
                <option value="Medio Ambiente">Medio Ambiente</option>
            </select>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="tags">Etiquetas</label>
        </div>
        <div class="controls">
            <ul class="nav nav-pills tag-list">
                <?php if($recurso->getDataset()->getTags()){ ?>
                    <?php foreach ($recurso->getDataset()->getTags() as $key => $tag){ ?>
                        <li><?php echo $tag->getNombre(); ?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="control-group">
        <div class="control-label">
            <label for="table">Hoja de Documento</label>
        </div>
        <div class="controls">
            <input type="number" class="input-small" name="table" id="table" value="0"/>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="control-group">
        <div class="control-label">
            <label for="description">Descripción</label>
        </div>
        <div class="controls">
            <textarea name="description" class="input-block-level" rows="3" id="description"><?php echo strip_tags($recurso->getDescripcion()); ?></textarea>
        </div>
    </div>
</form>
<div class="modal-footer">
    <button class="btn btn-primary" data-ajax-form-id="form-recurso-junar" data-ajax-command="enviarjunar" data-ajax-controller="recurso" data-disable="true" data-ajax-params="<?php echo $recurso->getId(); ?>">Enviar</button>
</div>