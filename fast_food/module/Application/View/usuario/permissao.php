<section class="content-header">
    <h1><?= $this->getTitle() ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-edit"></i> Usuário</a></li>
        <li class="active">Listagem</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?= $this->getMessage() ?>
    <a class="btn btn-warning btn-flat" href="javascript:history.go(-1)">Voltar</a>
</section>