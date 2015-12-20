<section class="content-header">
	<h1><?= $this->getTitle() ?></h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-edit"></i> Pedidos</a></li>
		<li class="active">Abertos</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<?= $this->getMessage() ?>

	<!-- Default box -->
	<div class="box">
		<!-- /.box-header -->
		<div class="box-body">
			<?php if (count($this->getAttribute('pedidos')) > 0): ?>
			<table id="tb-pedidos" class="table table-bordered table-actions">
				<thead>
				<tr>
					<th>Cliente</th>
					<th>Produtos</th>
					<th>Pagamento</th>
					<th>Valor</th>
                    <th>Aberto</th>
                    <th>Produção</th>
                    <th>Fechado</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($this->getAttribute('pedidos') as $pedido): ?>
					<tr>
						<td>
							<?= $pedido->cliente ?>
							<div class="actions">
								<a href="<?= '/pedidos/detalhes/' . $pedido->codigo ?>">Detalhar</a> |
								<a href="<?= '/pedidos/produzir/' . $pedido->codigo ?>" onclick="return confirm('Deseja iniciar a produção deste pedido?')">Produzir</a> |
								<a href="<?= '/pedidos/finalizar/' . $pedido->codigo ?>" onclick="return confirm('Deseja finalizar este pedido?')">Finalizar</a>
							</div>
						</td>
						<td><?= $pedido->produtos ?></td>
						<td><?= $pedido->str_pagamento ?></td>
						<td>R$ <?= $pedido->valor ?></td>
                        <td><?= $this->formatar_data($pedido->dt_aberto) ?></td>
                        <td><?= $this->formatar_data($pedido->dt_producao) ?></td>
                        <td><?= $this->formatar_data($pedido->dt_fechado) ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php else: ?>
			<p class="text-center">Não há pedidos para listar</p>
			<?php endif; ?>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>