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

                <!-- upload de imagens -->
                <div class="form-group">
                    <label>Imagem</label>
                    <div class="progress">
                        <div id="image-upload-progress" class="progress-bar progress-bar-green"></div>
                    </div>
                    <div class="upload-area text-center">
                        <input type="file" name="imagem[]" onchange="sendFiles(this)" multiple>
                        <h3>Arraste até aqui ou clique para fazer upload</h3>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row" id="box-imagens">
                    <?php
                        $itens = $this->getAttribute('imagens');
                        if ($itens != null && count($itens) > 0):
                            foreach ($itens as $imagem):
                    ?>
                    <div class="col-sm-2">
                        <img class="img-responsive img-circle margin-bottom" style="border: 1px solid #bbb" src="<?= $imagem->caminho ?>?w=160&h=160">
                    </div>
                    <?php
                            endforeach;
                        endif;
                    ?>
                    </div>
                </div>
                <!-- /upload de imagens -->

                <hr>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a class="btn btn-primary" href="/estoque/produtos">Listagem</a>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<script src="/assets/dist/js/main.js"></script>

<script>
    var pbar = document.getElementById('image-upload-progress');
    var boxImagens = document.getElementById('box-imagens');

    var options = {
        url: "/estoque/produtos/upload",

        progress: function(percent) {
            pbar.style.width = percent + "%";
        },

        success: function(response) {
            console.info(response);
            for (var k in response) {
                boxImagens.appendChild(
                    createThumbnail(response[k])
                );
            }
        },

        error: function(info) {
            alert('Oops! Algo deu errado, contate o administrador do sistema para mais informações');
            console.error(info);
        }
    };

    function hideModal()
    {
        modalWindow.style.display = 'none';
        modalOverlay.style.display = 'none';
    }

    function createThumbnail(item)
    {
        var img = document.createElement('img');
        img.setAttribute('class', 'img-responsive img-circle margin-bottom');
        img.setAttribute('src', item.caminho + '?w=160&h=160');

        var inp = document.createElement('input');
        inp.setAttribute('type', 'hidden');
        inp.setAttribute('name', 'img[]');

        var div = document.createElement('div');
        div.setAttribute('class', 'col-sm-2');
        div.appendChild(inp);
        div.appendChild(img);

        return div;
    }

    function sendFiles(field)
    {
        pbar.style.width = 0;
        var ajax = new Ajax(options);
        var data = new FormData();

        var files = field.files;
        for (var n = 0; n < files.length; n++) {
            data.append("imagem[]", files[n]);
        }

        ajax.send(data);
        field.value = null;

        return true;
    }
</script>