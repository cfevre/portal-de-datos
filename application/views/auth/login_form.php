<div class="span4 offset4">
	<form id="form-login" class="form" action="<?php echo site_url('auth/login'); ?>" method="POST">
		<fieldset>
			<div class="control-group">
				<div class="control-label">
					<label for="email">Email</label>
				</div>
				<div class="controls">
					<input class="input-block-level" type="text" value="" id="email" name="email">
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<label for="password">Clave</label>
				</div>
				<div class="controls">
					<input class="input-block-level" type="password" value="" id="password" name="password">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-primary" value="Acceder">
				</div>
			</div>
			<div class="controlgroup">
				<a href="<?php echo site_url('auth/recoverpassword'); ?>">Olvidé mi contraseña</a>
			</div>
			<input type="hidden" id="refering_url" name="refering_url" value="<?php echo base64_encode(site_url('backend')); ?>">
		</fieldset>
	</form>
</div>