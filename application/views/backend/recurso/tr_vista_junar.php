<tr id="vista-junar-<?php echo $vistaJunar->getId(); ?>" class="tr-vista-junar">
    <td class="vista-junar-title">
        <?php echo $vistaJunar->getTitle(); ?>
        <div class="message-holder"></div>
    </td>
    <td><?php echo $vistaJunar->getTableId(); ?></td>
    <td class="vista-junar-estado">
        <?php if($vistaJunar->getJunarGuid() != ''): ?>
            <span class="label label-mini label-success">
                <i class="icon-white icon-ok-circle"></i>
                <span>Enviado</span>
            </span>
            &nbsp;
            <a class="label label-mini label-info" target="_blank" href="<?php echo $this->config->item('junar_baseuri') . "/datastreams/" . $vistaJunar->getJunarGuid() . "?auth_key=" . $this->config->item('junar_authkey'); ?>">
                <i class="icon-white icon-search"></i>
                Ver
            </a>
        <?php else: ?>
            <span class="label label-mini label-warning">
                <i class="icon-white icon-minus-sign"></i>
                <span>Pendiente</span>
            </span>
        <?php endif; ?>
    </td>
    <td class="vistas-junar-acciones">
        <button data-ajax-command="enviarVistaJunar" data-ajax-controller="recurso" data-ajax-params="<?php echo $vistaJunar->getId(); ?>" data-ajax-message-holder="#vista-junar-<?php echo $vistaJunar->getId(); ?> .message-holder" data-disable="true" class="btn btn-mini btn-success"><i class="icon-white icon-refresh"></i> Enviar</button>
        <a href="<?php echo site_url('backend/recurso/editarVistaJunar/'.$vistaJunar->getId()); ?>" class="btn btn-mini btn-warning btn-junar ajax-modal" data-modal-header="Editar vista para Junar" data-disable="true"><i class="icon-edit icon-white"></i> <strong>Editar</strong></a>
        <a data-ajax-command="deleteVistaJunar" data-ajax-controller="recurso" data-ajax-params="<?php echo $vistaJunar->getId(); ?>" data-confirm="¿Está seguro que desea eliminar la vista [<?php echo $vistaJunar->getTitle(); ?>]?" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> Eliminar</a>
    </td>
</tr>