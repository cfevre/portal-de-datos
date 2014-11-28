<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Suscribirse a la Solicitud de Datos</h3>
</div>

<div class="modal-body">
	<h4>Para la suscripción a la solicitud ingresar tu Email:</h4>
	<input class="input-xlarge" type="email" placeholder="Ingresa tu Email" id="email-subscription">
	<h3 id="msg-subscription"></h3>
	<div id="email-noValido">
		
	</div>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <a id="save-subscription" class="btn btn-primary" data-id="<?php echo $participacion->getId(); ?>">Enviar</a>
</div>
