<section class="content-header">
    <h1><?= $this->getTitle() ?></h1>
    <ol class="breadcrumb">
        <li><a href="/usuarios"><i class="fa fa-edit"></i> Usuários</a></li>
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
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $this->data('nome') ?>">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $this->data('email') ?>">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" value="<?= $this->data('senha') ?>">
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="admin" <?= $this->data('admin') == '1' ? 'checked=""' : '' ?>> Administrador</label>
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