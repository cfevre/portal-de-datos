<div class="span4 offset4">
	<form id="form-login" class="form" action="<?php echo site_url('auth/sendpassword'); ?>" method="POST">
		<legend>¿Has olvidado tu contraseña?</legend>
		<fieldset>
			<div class="controlgroup">
				<p>
					Para restablecer la contraseña, escribe la dirección de correo electrónico completa que utilizas para acceder a tu cuenta y te enviaremos un correo con las instrucciones a seguir.
				</p>
			</div>
			<div class="control-group">
				<div class="control-label">
					<label for="email">Email</label>
				</div>
				<div class="controls">
					<input type="text" value="" id="email" name="email" class="input-block-level">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary" value="Enviar">
				</div>
			</div>
			<input type="hidden" id="refering_url" name="refering_url" value="<?php echo base64_encode(site_url('backend')); ?>">
		</fieldset>
	</form>
</div>