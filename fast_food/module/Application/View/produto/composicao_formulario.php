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
            <form role="form" method="post">
                <?php if ($this->getAttribute('acao') == 'cadastrar'): ?>
                <div class="form-group">
                    <label for="item">Nome</label>
                    <select class="form-control" id="item" name="item" onchange="preco(this)">
                        <option value="0" data-valor="0">Selecione</option>
                        <option value="0">-----</option>
                        <?php foreach ($this->getAttribute('res_itens') as $item): ?>
                        <option value="<?= $item->codigo ?>" data-valor="<?= $item->valor ?>" <?= $item->codigo == $this->data('item') ? 'selected=""' : '' ?>><?= $item->nome ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php else: ?>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $this->data('nome') ?>" disabled>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                    <input type="text" class="form-control" id="quantidade" name="quantidade" value="<?= intval($this->data('quantidade')) ?>">
                </div>
                <div class="form-group">
                    <label for="valor">Valor unitário</label>
                    <input type="text" class="form-control money-mask" id="valor" name="valor" value="<?= $this->data('valor') ?>">
                </div>
                <div class="form-group">
                    <?php $checked = $this->data('adicional') == '1' ? 'checked=""' : '' ?>
                    <label><input type="checkbox" name="adicional" value="1" <?= $checked ?>> Adicional</label>
                </div>

                <hr>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a class="btn btn-primary" href="<?= '/estoque/produtos/composicao/' . $this->data('produto') ?>">Listagem</a>
                </div>
                <input type="hidden" name="produto" value="<?= $this->data('produto') ?>">
            </form>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<script>
    var valorInput = document.getElementById('valor');

    function preco(select) {
        var option = select.options[select.selectedIndex];
        var valor = option.getAttribute('data-valor');
        valorInput.setAttribute('value', valor);
    }
</script>