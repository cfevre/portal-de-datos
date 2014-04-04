<div class="info-reportes">
    <?php if ($cant_reportes || (isset($cant_reportes_aprobacion) && $cant_reportes_aprobacion) || (isset($cant_reportes_moderacion) && $cant_reportes_moderacion)): ?>
        <h4>Reportes</h4>
    <?php endif ?>
    <?php if ($user->hasRol('mantencion')): ?>
        <?php if ($cant_reportes_aprobacion): ?>
            <div class="alert alert-info pull-right span12">
                Tiene <?php echo $cant_reportes_aprobacion; ?> dataset con reportes pendientes de aprobación.
            </div>
        <?php endif ?>
        <?php if ($cant_reportes_moderacion): ?>
            <div class="alert alert-success pull-right span12">
                <?php echo 'Tiene'; ?> <?php echo $cant_reportes_moderacion; ?> dataset pendientes de moderación.
            </div>
        <?php endif ?>
    <?php endif ?>
    <?php if ($cant_reportes): ?>
        <div class="alert alert-error pull-right span12">
            <?php echo $user->hasRol('mantencion')?'Hay ':'Tiene '; ?> <?php echo $cant_reportes; ?> dataset con reportes pendientes.
        </div>
    <?php endif ?>
</div>