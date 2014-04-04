<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST" id="formServicio">
    <fieldset>
        <legend><?php echo $servicio->getCodigo()?'Edición Servicio ['.$servicio->getNombre().']':'Nuevo Servicio'; ?></legend>
        <div class="control-group">
            <div class="control-label">
                <label for="codigo">Código <i class="icon-exclamation-sign"></i></label>
            </div>
            <div class="controls">
                <input type="text" name="codigo" id="codigo" class="input-xxlarge" value="<?php echo $servicio->getCodigo(); ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="nombre">Nombre <i class="icon-exclamation-sign"></i></label>
            </div>
            <div class="controls">
                <input type="text" name="nombre" id="nombre" class="input-xxlarge" value="<?php echo $servicio->getNombre(); ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="entidad_codigo">Entidad Padre</label>
            </div>
            <div class="controls">
                <select name="entidad_codigo" id="entidad_codigo" class="input-xxlarge">
                    <?php foreach ($entidades as $entidad): ?>
                        <?php $selected = $entidad == $servicio->getEntidad() ? 'selected="selected"' : ''; ?>
                        <option <?php echo $selected; ?> value="<?php echo $entidad->getCodigo(); ?>"><?php echo $entidad->getNombre(); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="sigla">Sigla</label>
            </div>
            <div class="controls">
                <input type="text" name="sigla" id="sigla" class="input-xxlarge" value="<?php echo $servicio->getSigla(); ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="url">Url</label>
            </div>
            <div class="controls">
                <input type="text" name="url" id="url" class="input-xxlarge" value="<?php echo $servicio->getUrl(); ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="oficial">Es Oficial</label>
            </div>
            <div class="controls">
                <input type="checkbox" name="oficial" id="oficial" class="input-xxlarge" value="1" <?php echo $servicio->getOficial() ? 'checked="checked"' : ''; ?>>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="publicado">Publicado</label>
            </div>
            <div class="controls">
                <input type="checkbox" name="publicado" id="publicado" class="input-xxlarge" value="1" <?php echo $servicio->getPublicado() ? 'checked="checked"' : ''; ?>>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="servicio_oficial">Servicio Oficial</label>
            </div>
            <div class="controls">
                <select name="servicio_oficial" id="servicio_oficial" class="chzn-select input-xxlarge">
                    <option value=""> - Seleccione - </option>
                    <?php foreach ($servicios as $key => $servicio_oficial){ ?>
                        <option <?php echo $servicio_oficial==$servicio->getServicioOficial()?'selected="selected"':''; ?> value="<?php echo $servicio_oficial->getCodigo(); ?>"><?php echo $servicio_oficial->getNombre(); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary">Grabar</button>
            <a class="btn btn-warning" href="<?php echo site_url('backend/servicio'); ?>">Cancelar</a>
        </div>
        <input type="hidden" value="<?php echo $servicio->getCodigo(); ?>" name="id" id="id">
    </fieldset>
</form>