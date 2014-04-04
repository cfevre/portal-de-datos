<div class="page-header">
  <h1>Tipos de Reporte <small></small></h1>
</div>
<a href="<?php echo site_url('backend/tiporeporte/add'); ?>" class="btn btn-primary">Nuevo Tipo de Reporte</a>
<hr>
<table id="tabla-tipos-reporte" class="table table-striped">
    <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                Titulo
            </th>
            <th>
                Grado
            </th>
            <th>
                Acceso
            </th>
            <th>
                Acciones
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if ($tiposReporte): ?>
            <?php foreach ($tiposReporte as $key => $tipoReporte){ ?>
                <tr id="tipo-reporte-<?php echo $tipoReporte->getId(); ?>">
                    <td><?php echo $tipoReporte->getId(); ?></td>
                    <td><?php echo $tipoReporte->getTitulo(); ?></td>
                    <td>
                        <?php echo $tipoReporte->getGradoReporte()->getNombre(); ?>
                    </td>
                    <td>
                        <?php echo $tipoReporte->getPublico()?'Público':'Interno'; ?>
                    </td>
                    <td>
                        <a href="<?php echo site_url('backend/tiporeporte/edit/'.$tipoReporte->getId()); ?>" class="btn btn-success btn-small"><i class="icon-edit"></i> Editar</a>
                        <button data-id="<?php echo $tipoReporte->getId(); ?>" data-name="<?php echo $tipoReporte->getTitulo(); ?>" class="btn btn-small btn-danger delete-tipo-reporte"><i class="icon-remove"></i> Eliminar</button>
                    </td>
                </tr>   
            <?php } ?>
        <?php else: ?>
            <tr>
                <th style="text-align:center" colspan="4">No se han encontrado Licencias.</th>
            </tr>           
        <?php endif ?>
    </tbody>
</table>