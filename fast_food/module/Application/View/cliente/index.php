<section class="content-header">
	<h1><?= $this->getTitle() ?> <a class="btn btn-primary btn-sm" href="/clientes/cadastrar">Cadastrar</a></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-edit"></i> Clientes</a></li>
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
					<th>Imagem</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($this->getAttribute('clientes') as $cliente): ?>
					<tr id="cliente-<?= $cliente->codigo ?>">
						<td>
							<?= $cliente->nome ?>
							<div class="actions">
								<a href="<?= '/clientes/alterar/' . $cliente->codigo ?>">Alterar</a> |
								<a href="<?= '/clientes/excluir/' . $cliente->codigo ?>" onclick="return confirm('Deseja realmente excluir cliente?')">Excluir</a>
							</div>
						</td>
						<td><?= $cliente->email ?></td>
						<td><img class="img-responsive img-circle" src="<?= empty($cliente->imagem) ? '/upload/clientes/sem_imagem.png?w=40&h=40' : $cliente->imagem ?>?w=40&h=40" alt="Foto do cliente"></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>