<section class="content-header">
	<h1><?= $this->getTitle() ?></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-edit"></i> Pedidos</a></li>
		<li class="active">Abertos</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="box">
		<!-- /.box-header -->
		<div class="box-body">
			<table id="tb-pedidos" class="table table-bordered table-actions">
				<thead>
				<tr>
					<th>Cliente</th>
					<th>Produtos</th>
					<th>Pagamento</th>
					<th>Valor</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($this->getAttribute('pedidos') as $pedido): ?>
					<tr>
						<td>
							<?= $pedido->cliente ?>
							<div class="actions">
								<a href="<?= '/pedidos/detalhes/' . $pedido->codigo ?>">Detalhar</a> |
								<a href="#">Finalizar</a>
							</div>
						</td>
						<td><?= $pedido->produtos ?></td>
						<td><?= $pedido->str_pagamento ?></td>
						<td>R$ <?= $pedido->valor ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>