<section class="content-header">
    <h1><?= $this->getTitle() ?></h1>
    <ol class="breadcrumb">
        <li><a href="/estoque/produtos"><i class="fa fa-edit"></i> Produtos</a></li>
        <li class="active">Cadastrar / Alterar</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?= $this->getMessage() ?>
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <form role="form" method="post" enctype="multipart/form-data">
                <!-- text input -->
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="nome" value="<?= $this->data('nome') ?>">
                </div>
                <div class="form-group">
                    <label>Valor</label>
                    <input type="text" class="form-control money-mask" name="valor" value="<?= $this->data('valor') ?>">
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="categoria" class="form-control select2" style="width: 100%;">
                        <?php foreach ($this->data['categorias'] as $categoria): ?>
                            <option value="<?= $categoria->codigo ?>" <?= $categoria->codigo == $this->data['categoria'] ? 'selected="selected"' : '' ?>><?= $categoria->nome ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Imagens</label>
                    <input type="file" name="imagens[]" multiple>
                    <?php foreach ($this->getAttribute('imagens') as $imagem): ?>
                        <div class="col-sm-1">
                            <img class="img-responsive" src="<?= $imagem->caminho ?>" alt="<?= $imagem->titulo ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a class="btn btn-primary" href="<?= str_replace('/cadastrar', '', $this->url) ?>">Listagem</a>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
</section>