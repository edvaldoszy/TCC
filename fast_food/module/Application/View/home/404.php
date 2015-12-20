<section class="content-header">
    <h1><?= $this->getTitle() ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="error-page text-center">
        <h1 class="text-yellow" style="font-size: 100px;">404</h1>

        <h3><i class="fa fa-warning text-yellow"></i> Oops! Página não encontrada.</h3>

        <p>
            A página que você está procurando não existe ou está indisponível no momento<br>
            retorne ao <a href="/">painel principal</a> ou a <a href="javascript:history.go(-1)">página anterior</a>
        </p>
        <p>Página: <?= $this->getAttribute('pagina') ?></p>
        <p><?php print_r($this->getAttribute('parametros')) ?></p>
    </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->