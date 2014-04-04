<?php
    $cant_reportes = $this->doctrine->em->getRepository('Entities\Reporte')->getReportesPendientesDataset($dataset->getId());
?>
<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav">
			<li<?php echo $active == 'view'?' class="active"':''; ?>><a href="<?php echo site_url('backend/dataset/view/'.$dataset->getId()); ?>">Ver</a></li>
			<li<?php echo $active == 'edit'?' class="active"':''; ?>><a href="<?php echo site_url('backend/dataset/edit/'.$dataset->getId()); ?>">Editar</a></li>
			<li<?php echo $active == 'versions'?' class="active"':''; ?>><a href="<?php echo site_url('backend/dataset/versions/'.$dataset->getId()); ?>">Versiones</a></li>
			<li<?php echo $active == 'history'?' class="active"':''; ?>><a href="<?php echo site_url('backend/dataset/history/'.$dataset->getId()); ?>">Historial</a></li>
            <li<?php echo $active == 'reportes'?' class="active"':''; ?>><a href="<?php echo site_url('backend/reporte/dataset/'.$dataset->getId()); ?>">Reportes (<?php echo $cant_reportes; ?>)</a></li>
		</ul>
	</div>
</div>