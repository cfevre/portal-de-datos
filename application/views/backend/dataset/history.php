<table class="table table-bordered table-hover">
	<tbody>
		<?php foreach ($dataset->getLogMaestro() as $key => $log){ ?>
		<tr>
			<td width="25%">
				<strong>Fecha de modificación:</strong><br /><?php echo $log->getCreatedAt()->format('d/m/Y H:i'); ?><br />
                <?php if($log->getUsuario()): ?>
				    <strong>Usuario:</strong><br /><?php echo $log->getUsuario()->getEmail(); ?><br />
                <?php endif; ?>
			</td>
			<td>
				<strong>Dataset: #<?php echo $log->getDatasetMaestro()->getId(); ?></strong>
				<strong>Versión: <a href="<?php echo site_url('backend/dataset/view/'.$log->getDatasetVersion()->getId()); ?>">#<?php echo $log->getDatasetVersion()->getId(); ?></a></strong><br />
				<strong>Cambios realizados:</strong><br />
				<?php echo $log->getDescripcion(); ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>