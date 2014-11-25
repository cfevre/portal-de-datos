<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav">
			<li<?php echo $active == 'view'?' class="active"':''; ?>><a href="<?php echo site_url('backend/participacion/view/'.$participacion->getId()); ?>">Ver</a></li>
			<li<?php echo $active == 'edit'?' class="active"':''; ?>><a href="<?php echo site_url('backend/participacion/edit/'.$participacion->getId()); ?>">Editar</a></li>
		</ul>
	</div>
</div>