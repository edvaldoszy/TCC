<section class="content-header">
	<h1>Produtos <a class="btn btn-primary btn-sm" href="/estoque/produtos/cadastrar">Cadastrar</a></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-edit"></i> Produtos</a></li>
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
					<th>Categoria</th>
					<th>Valor</th>
					<th>Ativo</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($this->getAttribute('produtos') as $produto): ?>
					<tr id="produto-<?= $produto->codigo ?>">
						<td>
							<?= $produto->nome ?>
							<div class="actions">
								<a href="<?= '/estoque/produtos/alterar/' . $produto->codigo ?>">Alterar</a> |
								<a href="<?= '/estoque/produtos/composicao/' . $produto->codigo ?>">Composição</a> |
								<a href="<?= '/estoque/produtos/excluir/' . $produto->codigo ?>" onclick="return confirm('Deseja realmente excluir este produto?')">Excluir</a>
							</div>
						</td>
						<td><?= $produto->categoria ?></td>
						<td>R$ <?= $produto->valor ?></td>
						<td><?= $produto->str_ativo ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>