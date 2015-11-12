<section class="content-header">
	<h1><?= $this->getTitle() ?> <a class="btn btn-primary btn-sm" href="/usuarios/cadastrar">Cadastrar</a></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-edit"></i> Usuário</a></li>
		<li class="active">Listagem</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<?= $this->getMessage() ?>
	<!-- Default box -->
	<div class="box">
		<!-- /.box-header -->
		<div class="box-body">
			<table id="tb-produtos" class="table table-bordered table-actions">
				<thead>
				<tr>
					<th>Nome</th>
					<th>E-mail</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($this->getAttribute('usuarios') as $usuario): ?>
					<tr id="produto-<?= $usuario->codigo ?>">
						<td>
							<?= $usuario->nome ?>
							<div class="actions">
								<a href="<?= '/usuarios/alterar/' . $usuario->codigo ?>">Alterar</a> |
								<a href="<?= '/usuarios/excluir/' . $usuario->codigo ?>" onclick="return confirm('Deseja realmente excluir este produto?')">Excluir</a>
							</div>
						</td>
						<td><?= $usuario->email ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>