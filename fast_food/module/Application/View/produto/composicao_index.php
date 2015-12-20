<section class="content-header">
    <h1>
        Composição de <?= $this->getAttribute('produto')->nome ?>
        <a class="btn btn-primary btn-sm" href="<?= '/estoque/produtos/composicao/cadastrar/' . $this->getAttribute('produto')->codigo ?>">Cadastrar</a>
        <a class="btn btn-primary btn-sm" href="/estoque/produtos">Produtos</a>
    </h1>
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
            <?php $itens = $this->getAttribute('itens'); if (count($itens) > 0): ?>
            <table id="tb-produtos" class="table table-bordered table-actions">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Quantidade</th>
                    <th>Adicional</th>
                    <th>Valor</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($itens as $item): ?>
                    <tr id="produto-<?= $item->codigo ?>">
                        <td>
                            <?= $item->nome ?>
                            <div class="actions">
                                <a href="<?= '/estoque/produtos/composicao/alterar/' . $item->produto_codigo . '/' . $item->item_codigo ?>">Alterar</a> |
                                <a href="<?= '/estoque/produtos/composicao/excluir/' . $item->produto_codigo . '/' . $item->item_codigo ?>" onclick="return confirm('Deseja realmente excluir este produto?')">Excluir</a>
                            </div>
                        </td>
                        <td><?= $item->categoria ?></td>
                        <td><?= ceil($item->quantidade) ?></td>
                        <td><?= $item->str_adicional ?></td>
                        <td>R$ <?= $item->valor ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p class="text-center">Não há itens na lista</p>
            <?php endif; ?>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>