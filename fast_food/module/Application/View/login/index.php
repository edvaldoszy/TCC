<div class="login-box-body">
	<p class="login-box-msg">Faça login para iniciar uma sessão</p>
	<?= $this->getMessage() ?>
	<form action="/login?redirect=<?= $this->redirect ?>" method="post">
		<div class="form-group has-feedback">
			<input type="email" name="email" class="form-control" placeholder="Email" value="<?= $this->getAttribute('email') ?>">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="form-group has-feedback">
			<input type="password" name="senha" class="form-control" placeholder="Senha" value="<?= $this->getAttribute('senha') ?>">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
		</div>
	</form>

	<a href="/login/senha/<?= $this->getAttribute('email') ?>">Esqueci minha senha</a><br>
</div>