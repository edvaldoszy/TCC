<section class="content-header">
    <h1><?= $this->getTitle() ?></h1>
    <ol class="breadcrumb">
        <li><a href="/usuarios"><i class="fa fa-edit"></i> Produtos</a></li>
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
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="email" value="<?= $this->data('email') ?>">
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" class="form-control" name="senha" value="<?= $this->data('senha') ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a class="btn btn-primary" href="/usuarios">Listagem</a>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
</section>