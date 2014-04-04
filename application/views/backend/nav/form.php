<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST">
	<fieldset>
		<legend><?php echo $nav->getId()?'Edición menú ['.$nav->getId().']':'Nuevo menú'; ?></legend>
		<div class="control-group">
			<div class="control-label">
				<label for="title">Título</label>
			</div>
			<div class="controls">
				<input type="text" name="title" id="title" class="input-xlarge" value="<?php echo $nav->getTitle(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="alias">Alias</label>
			</div>
			<div class="controls">
				<input type="text" name="alias" id="alias" class="input-xlarge" value="<?php echo $nav->getAlias(); ?>">
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="position">
					Posición
					<i class="icon-question-sign popover-icon" data-content="La posición en la que se incluirá el menu dentro del template.<br>Se puede especificar mas de una posición separandolas con una coma ( , )<br>Ej: <strong>main_menu, side_menu</strong>" data-trigger="hover" data-original-title="Posición"></i>
				</label>
			</div>
			<div class="controls">
				<input type="text" name="position" id="position" class="input-xlarge" value="<?php echo $nav->getPosition(); ?>">
			</div>
		</div>
		<legend>Items del Menú</legend>
		<div class="control-group">
			<a href="<?php echo site_url('backend/nav/additem/'.$nav->getId()); ?>" class="btn btn-success btn-small">Agregar Item</a>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Título</th>
					<th>Alias</th>
					<th>Pagina</th>
					<th>Layout</th>
					<th style="text-align:center;">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($nav->getItems() as $key => $item){ ?>
					<?php
						echo getItemRow($item, 0);
					?>
				<?php } ?>
			</tbody>
		</table>
		<div class="form-actions">
			<button class="btn btn-primary">Guardar</button>
			<a class="btn" href="<?php echo site_url('backend/nav'); ?>">Cancelar</a>
		</div>
		<input type="hidden" name="id" id="id" value="<?php echo $nav->getId(); ?>">
	</fieldset>
</form>
<?php
	function getItemRow($navItem, $level = 0){
		if($navItem->getPage()){
			$page = $navItem->getPage()->getTitle();
		}else{
			if(filter_var($navItem->getCustomurl(), FILTER_VALIDATE_URL)){
				$page = $navItem->getCustomurl().' *';
			}else{
				$page = site_url($navItem->getCustomurl()).' *';
			}
		}
		$row = '<tr id="item-'.$navItem->getId().'">';
		$row .= '<td>'.$navItem->getOrdering().'</td>';
		$row .= '<td>'.str_repeat('|-- ',$level).'<a href="'.site_url('backend/nav/edititem/'.$navItem->getId()).'">'.$navItem->getTitle().'</a></td>';
		$row .= '<td>'.$navItem->getAlias().'</td>';
		$row .= '<td>'.$page.'</td>';
		$row .= '<td>'.$navItem->getLayout().'</td>';
		$row .= '<td nowrap style="text-align:center;">';
		$row .= getItemPublishedButton($navItem);
		$row .= '&nbsp;';
		$row .= '<a href="'.site_url("backend/nav/deleteitem/".$navItem->getId()).'" class="btn btn-danger btn-small">Eliminar</a>';
		$row .= '</td>';
		$row .= '</tr>';
		
		if($navItem->getChildren()){
			foreach ($navItem->getChildren() as $key => $subItem) {
				$row .= getItemRow($subItem, $level+1);
			}
		}

		return $row;
	}
	function getItemPublishedButton($navItem){
		if(!$navItem->getPublished()){
			$btn = '<button data-ajax-command="togglePublicado" data-ajax-controller="nav" data-ajax-params="?id='.$navItem->getId().'" class="btn btn-mini btn-warning">
							<i class="icon-ban-circle"></i>
							<span>No Publicado</span>
						</button>';
		}else{ 
			$btn = '<button data-ajax-command="togglePublicado" data-ajax-controller="nav" data-ajax-params="?id='.$navItem->getId().'" class="btn btn-mini btn-success">
							<i class="icon-ok-circle"></i>
							<span>Publicado</span>
						</button>';
		}
		return $btn;
	}
?>