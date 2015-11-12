<section class="content-header">
    <h1><?= $this->getTitle() ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-edit"></i> Categorias</a></li>
        <li class="active">Cadastrar / Alterar</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?= $this->getMessage() ?>
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <form role="form" method="post">
                <!-- text input -->
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="nome" value="<?= $this->data('nome') ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-primary" onclick="location.href = '/categorias'">Listagem</button>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
</section>