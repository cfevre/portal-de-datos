<h3>Reporte para el dataset: <?php echo $dataset->getTitulo(); ?></h3>
<table class="table table-striped">
    <tr>
        <th width="15%">Tipo de reporte</th>
        <td><?php echo $reporte->getTipoReporte()->getTitulo(); ?></td>
    </tr>
    <tr>
        <th>Grado de reporte</th>
        <td><?php echo $reporte->getTipoReporte()->getGradoReporte()->getNombre(); ?></td>
    </tr>
    <tr>
        <th>Estado</th>
        <td><?php echo $reporte->getEstado(true); ?></td>
    </tr>
    <tr>
        <th>Origen</th>
        <td><?php echo $reporte->getOrigenPublico()?'Público':'Interno'; ?></td>
    </tr>
    <?php if ($user->hasRol('mantencion')): ?>
        <?php if ($reporte->getNombre()): ?>
        <tr>
            <th>Nombre</th>
            <td><?php echo $reporte->getNombre(); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($reporte->getEmail()): ?>
        <tr>
            <th>Email</th>
            <td><?php echo $reporte->getEmail(); ?></td>
        </tr>
        <?php endif; ?>
    <?php endif; ?>
    <tr>
        <th>Comentarios</th>
        <td><?php echo $reporte->getComentarios(); ?></td>
    </tr>
    <tr>
        <th>Fecha de Ingreso</th>
        <td><?php echo $reporte->getCreatedAt()->format('d/m/Y'); ?></td>
    </tr>
</table>