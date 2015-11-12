<div class="login-box-body">
	<p class="login-box-msg">Informe seu e-mail para recuperar sua senha</p>
	<?= $this->getMessage() ?>
	<form action="/login/senha" method="post">
		<div class="form-group has-feedback">
			<input type="email" name="email" class="form-control" placeholder="Email" value="<?= $this->getAttribute('email') ?>">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
		</div>
	</form>

	<a href="/login">Fazer login</a><br>
</div>