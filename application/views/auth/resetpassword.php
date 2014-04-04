<div class="span4 offset4">
	<form id="form-login" class="form" action="<?php echo site_url('auth/performpasswordreset'); ?>" method="POST">
		<legend>Elije tu nueva contraseña</legend>
		<fieldset>
			<div class="control-group">
				<div class="control-label">
					<label for="password">Nueva Clave</label>
				</div>
				<div class="controls">
					<input class="input-block-level" type="password" value="" id="password" name="password">
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<label for="passwordconfirm">Confirma tu Nueva Clave</label>
				</div>
				<div class="controls">
					<input class="input-block-level" type="password" value="" id="passwordconfirm" name="passwordconfirm">
				</div>
			</div>
			<div class="control-group">
				<p><script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LdPI9kSAAAAADIKGtUlaNYYcH55_4eviM0zwxc3"></script></p>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary" value="Enviar">
				</div>
			</div>
			<input type="hidden" id="reset_code" name="reset_code" value="<?php echo $this->data['reset_code']; ?>">
		</fieldset>
	</form>
</div>