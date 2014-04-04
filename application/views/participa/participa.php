<h2 class="participa">Participa </h2>
<div class="row-fluid">
	<div class="span4">
		<div class="well gris">
		  <div id="accordion2" class="accordion">
		    <div class="accordion-group">
		    	<h4>Colabora para tener un gobierno más transparente.</h4>
          <p>
						A través de este formulario cuéntanos como podemos mejorar el sitio, qué datos te gustaría que estuvieran disponibles, qué información debiéramos incluir o simplemente cómo podríamos hacer que tu experiencia sea más satisfactoria en una próxima visita.
					</p>
          <p>&nbsp;</p>
          <div class="row-fluid">
        		<div class="form-messages"></div>
	          <form class="ajax-form" action="<?php echo site_url('participa/add'); ?>" method="post">
						  <label for="nombre">Nombre <span class="naranjo">*</span></label>
						  <input tabindex="1" class="input-block-level" type="text" id="nombre" name="nombre">
						  <label for="apellidos">Apellidos <span class="naranjo">*</span></label>
					    <input tabindex="2" class="input-block-level" type="text" id="apellidos" name="apellidos">
						  <label for="email">Email <span class="naranjo">*</span></label>
						  <input tabindex="3" class="input-block-level" type="text" id="email" name="email">
						  <label for="titulo">Asunto <span class="naranjo">*</span></label>
					    <input tabindex="4" class="input-block-level" type="text" id="titulo" name="titulo">
						  <label for="categoria">Categoría <span class="naranjo">*</span></label>
						  <select tabindex="5" class="input-block-level" name="categoria" id="categoria">
						  	<option value="">- Seleccione -</option>
						  	<option value="duda">Duda</option>
						  	<option value="publicacion">Publicación de nuevo dataset</option>
						  	<option value="idea">Mejora en el portal</option>
                            <option value="visualizacion">Visualización</option>
						  	<option value="otros">Otros</option>
						  </select>
              <label for="mensaje">Mensaje <span class="naranjo">*</span></label>
              <textarea tabindex="6" class="input-block-level" name="mensaje" id="mensaje" cols="" rows="10"></textarea>
              <p><script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LdPI9kSAAAAADIKGtUlaNYYcH55_4eviM0zwxc3"></script></p>
	          	<p class="pull-right"><span class="naranjo">*</span> Campo Obligatorio</p>
              <button tabindex="7" type="submit" class="btn btn-warning">Enviar</button>
	          </form>
	        </div>
		    </div>
		  </div>
		</div>
	</div>
	<div class="span8">
		<div class="row-fluid borde-b">
		  <div class="span8">
		    <h3>Participaciones </h3>
		  </div>
		  <div class="span4 padding15">
				<form class="form-search" id="formOrdenarPor" action="<?php echo current_url(); ?>" method="GET">
					<label for="orderby">Ordenar por</label>
					<select name="orderby" id="orderby" data-auto-submit="change" data-submit-form="formOrdenarPor">
						<option value="created_at"<?php echo $orderby=='created_at'?' selected="selected"':''; ?>>Más nuevos</option>
				    <option value="titulo"<?php echo $orderby=='titulo'?' selected="selected"':''; ?>>Título</option>
					</select>
				</form>
		  </div>
		</div>
		<?php if($participaciones){ ?>
			<?php foreach ($participaciones as $key => $participacion){ ?>
				<div class="participacion row-fluid borde-b">
					<div class="span9">
						<h4>
							<a class="modal-trigger" href="<?php echo site_url('participa/ver/'.$participacion->getId()); ?>" data-target="#modalParticipacion" ><?php echo $participacion->getTitulo(); ?></a>
						</h4>
						<p>
							<?php echo stringsHelper::truncate_words($participacion->getMensaje()); ?>
						</p>
					</div>
					<div class="span3 padding15">
						<p>
							<span class="naranjo">Usuario: </span><?php echo $participacion->getNombre().' '.$participacion->getApellidos(); ?>
						</p>
						<p>
							<span class="naranjo">Fecha: </span><?php echo $participacion->getCreatedAt()->format('d/m/Y'); ?>
						</p>
						<?php /*<div class="row-fluid">
							<div class="span6 v-positivo">10</div>
							<div class="span6 v-negativo">10</div>
						</div>*/ ?>
					</div>
				</div>
			<?php } ?>
			<?php echo $pagination; ?>
		<?php } ?>	
	</div>
</div>

<div id="modalParticipacion" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">

</div>