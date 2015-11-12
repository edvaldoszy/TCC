<section class="content-header">
    <h1>Categorias <a class="btn btn-primary btn-sm" href="/categorias/cadastrar">Cadastrar</a></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-edit"></i> Categorias</a></li>
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
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->getAttribute('categorias') as $categoria): ?>
                    <tr id="categoria-<?= $categoria->codigo ?>">
                        <td>
                            <?= $categoria->nome ?>
                            <div class="actions">
                                <a href="/categorias/alterar/<?= $categoria->codigo ?>">Alterar</a> |
                                <a href="/categorias/excluir/<?= $categoria->codigo ?>" onclick="return confirm('Deseja realmente excluir esta categoria?')">Excluir</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>