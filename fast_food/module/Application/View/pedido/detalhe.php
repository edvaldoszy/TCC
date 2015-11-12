<section class="content-header">
    <h1>Detalhes do pedido</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-edit"></i> Pedidos</a></li>
        <li class="active">Detalhes</li>
    </ol>
</section>
<?php $pedido = $this->getAttribute('pedido') ?>
<!-- Main content -->
<section class="content">
    <!-- .row -->
    <div class="row">
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cliente</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body"><?= $pedido->cliente->nome ?></div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Forma de pagamento</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body"><?= $pedido->str_pagamento ?></div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Valor total</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">R$ <?= $pedido->valor ?></div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->

    <?php foreach ($pedido->detalhes as $detalhe): ?>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $detalhe->produto->nome ?></h3>
                <span class="label pull-right bg-red"><?= $detalhe->quantidade ?></span>
            </div>
            <div class="box-body">
                <table id="tb-pedidos" class="table table-bordered table-actions">
                    <thead>
                    <tr>
                        <th width="60%">Item</th>
                        <th width="20%">Valor un.</th>
                        <th width="20%">Valor total</th>
                        <th width="20%">Quantidade</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($detalhe->itens as $item): ?>
                        <tr>
                            <td><?= $item->nome ?></td>
                            <td>R$ <?= $item->valor ?></td>
                            <td>R$ <?= $item->valor_total ?></td>
                            <td><?= intval($item->quantidade) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</section>