<div class="page-header">
    <h1>Menús <small></small></h1>
</div>
<a href="<?php echo site_url('backend/nav/add'); ?>" class="btn btn-primary">Nuevo Menú</a>
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th>Título</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($navs): ?>
			<?php foreach ($navs as $key => $nav){ ?>
				<tr>
					<td><?php echo $nav->getId(); ?></td>
					<td><a href="<?php echo site_url('backend/nav/edit/'.$nav->getId()); ?>"><?php echo $nav->getTitle(); ?></a></td>
				</tr>	
			<?php } ?>
		<?php else: ?>
			<tr>
				<th style="text-align:center" colspan="2">No se han encontrado Menús.</th>
			</tr>			
		<?php endif ?>
	</tbody>
</table>