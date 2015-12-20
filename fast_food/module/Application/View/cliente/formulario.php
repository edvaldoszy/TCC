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
                    <input type="email" class="form-control" name="email" value="<?= $this->data('email') ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" value="<?= $this->data('senha') ?>" autocomplete="off">
                    <?= isset($this->alterar) ? '<p class="text-red">Preencha o campo senha apenas para alterar a senhra atual</p>' : '' ?>
                </div>

                <!-- upload de imagens -->
                <div class="form-group">
                    <label>Imagem</label>
                    <div class="progress">
                        <div id="image-upload-progress" class="progress-bar progress-bar-green"></div>
                    </div>
                    <div class="upload-area text-center">
                        <input type="file" name="imagem" onchange="sendFiles(this)">
                        <h3>Arraste até aqui ou clique para fazer upload</h3>
                    </div>
                </div>
                <div class="form-group">
                    <img id="imagem-cliente" class="img-responsive img-circle center-block" style="border: 1px solid #bbb" src="<?= $this->data('imagem') ?>" alt="Imagem do cliente">
                </div>
                <!-- /upload de imagens -->

                <hr>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a class="btn btn-primary" href="/clientes">Listagem</a>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<script src="/assets/dist/js/main.js"></script>
<script>
    var pbar = document.getElementById('image-upload-progress');
    var imagemCliente = document.getElementById('imagem-cliente');

    var options = {
        url: "/clientes/upload",

        progress: function(percent) {
            pbar.style.width = percent + "%";
        },

        success: function(response) {
            console.info(response);
            imagemCliente.src = response.caminho + '?w=160&h=160';
        },

        error: function(info) {
            alert('Oops! Algo deu errado, contate o administrador do sistema para mais informações');
            console.error(info);
        }
    };

    function sendFiles(field)
    {
        pbar.style.width = 0;
        var ajax = new Ajax(options);
        var data = new FormData();

        data.append("imagem", field.files[0]);
        ajax.send(data);
        field.value = null;

        return true;
    }
</script>