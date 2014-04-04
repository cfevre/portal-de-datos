<table class="table">
	<thead>
		<tr>
			<th>Versión #</th>
			<th>Fecha</th>
			<th>
                <span class="popover-icon" data-content="Sólo es posible publicar datasets con recursos asociados." data-trigger="hover" data-original-title="Publicación de Datasets">Publicado<i class="icon-question-sign"></i></span>
            </th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($versiones as $key => $version){ ?>
			<tr id="dataset-<?php echo $version->getId(); ?>">
				<td><?php echo $version->getId(); ?></td>
				<td><?php echo $version->getCreatedAt()->format('d-m-Y H:i:s'); ?></td>
				<td>
					<?php if(!$version->getPublicado()){ ?>
                        <?php if (count($version->getRecursos())): ?>
                            <button <?php echo $this->user->hasRol('publicacion')?'':'disabled="disabled"'; ?> data-ajax-command="togglePublicado" data-ajax-controller="dataset" data-ajax-params="?id=<?php echo $version->getId(); ?>" class="btn btn-warning">
                                <i class="icon-ban-circle"></i>
                                <span>Publicar</span>
                            </button>
                        <?php else: ?>
                            <span class="label label-important">Sin recursos</span>
                        <?php endif ?>
					<?php }else{ ?>
						<button <?php echo $this->user->hasRol('publicacion')?'':'disabled="disabled"'; ?> data-ajax-command="togglePublicado" data-ajax-controller="dataset" data-ajax-params="?id=<?php echo $version->getId(); ?>" class="btn btn-success">
							<i class="icon-ok-circle"></i>
							<span>Despublicar</span>
						</button>
					<?php } ?>
				</td>
				<td><a href="<?php echo site_url('backend/dataset/view/'.$version->getId()); ?>">Ver Versión</a></td>
			</tr>
		<?php } ?>
	</tbody>
</table>