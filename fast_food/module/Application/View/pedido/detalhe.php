<section class="content-header">
    <h1>Detalhes do pedido</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-edit"></i> Pedidos</a></li>
        <li class="active">Detalhes</li>
    </ol>
</section>
<?php $pedido = $this->getAttribute('pedido') ?>
<!-- Main content -->
<section class="content">
    <!-- .row -->
    <div class="row">
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cliente</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body"><?= $pedido->cliente->nome ?></div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Endereço de entrega</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php $endereco = $pedido->endereco; ?>
                    <?= $endereco->logradouro . ', ' . $endereco->numero . ' - ' . $endereco->bairro ?>
                    <?= ', ' . $endereco->cidade->nome . ' - ' . $endereco->cidade->uf ?>
	                <?php $str = $endereco->logradouro . ', ' . $endereco->numero . ' - ' . $endereco->bairro . ', ' . $endereco->cidade->nome . ' - ' . $endereco->cidade->uf ?>
                    <br><a href="#" id="btn-ver-mapa" data-endereco="<?= $str ?>">Ver no mapa</a>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Valor total</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">R$ <?= $pedido->valor ?> - Pagamento em <?= $pedido->str_pagamento ?></div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->

    <?php foreach ($pedido->detalhes as $detalhe): ?>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $detalhe->produto->nome ?></h3>
                <span class="label pull-right bg-red"><?= $detalhe->quantidade ?></span>
            </div>
            <div class="box-body">
                <table id="tb-pedidos" class="table table-bordered table-actions">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th width="20%">Valor un.</th>
                        <th width="20%">Valor total</th>
                        <th width="10%">Quantidade</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($detalhe->itens as $item): ?>
                        <tr>
                            <td><?= $item->nome ?></td>
                            <td>R$ <?= $item->valor ?></td>
                            <td>R$ <?= $item->valor_total ?></td>
                            <td><?= intval($item->quantidade) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</section>
<style type="text/css">
    .modal-overlay {
        display: none;
        z-index: 9999999997;
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .8);
    }
    .modal-window {
        display: none;
        z-index: 9999999998;
        position: fixed;
        left: 20px;
        top: 20px;
        right: 20px;
        bottom: 20px;
        background: #eeeeef url("/assets/dist/img/loading-wheel.gif") no-repeat center center;
    }
    .modal-window .btn-close {
        z-index: 9999999999;
        position: absolute;
        top: 6px;
        right: 10px;
        cursor: pointer;
    }
    .modal-window #mapa {
        width: 100%;
        height: 100%;
    }
</style>
<div class="modal-overlay"></div>
<div class="modal-window" data-aberto="nao">
    <div class="btn-close" onclick="Modal.hide()"><img src="/assets/dist/img/btn-modal-close.png" alt="Close modal" title="Fechar janela"></div>
    <div id="mapa"></div>
</div>
<script>

    function iniciarMapa(endereco)
    {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;

        var mapa = new google.maps.Map(document.getElementById('mapa'), {
            //center: {lat: parseInt(latitude), lng: parseInt(longitude)},
            scrollwheel: true,
            zoom: 15
        });
        directionsDisplay.setMap(mapa);

        directionsService.route({
            origin: 'Av. Guilherme de Paula Xavier, 871 - Centro, Campo Mourão - PR, Brasil',
            destination: endereco,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            } else {
                console.info(status);
                alert('Não foi possível calcular a rota para seu endereço');
            }
        });

        return mapa;
    }

    var modalOverlay = document.querySelector('.modal-overlay');
    modalOverlay.onclick = function () {
        Modal.hide();
    };

    var modalWindow = document.querySelector('.modal-window');

    var Modal = {

        mapa: null,

        show: function(endereco)
        {
            modalOverlay.style.display = 'block';
            modalWindow.style.display = 'block';

            if (modalWindow.getAttribute('data-aberto') == 'nao') {
                modalWindow.setAttribute('data-aberto', 'sim');

                this.mapa = iniciarMapa(endereco);
            }
        },

        hide: function()
        {
            modalOverlay.style.display = 'none';
            modalWindow.style.display = 'none';
        },

        toggle: function()
        {
            if (modalOverlay.style.display == 'block' && modalWindow.style.display == 'block') {
                modalOverlay.style.display = 'none';
                modalWindow.style.display = 'none';
            } else {
                modalOverlay.style.display = 'block';
                modalWindow.style.display = 'block';
            }
        }
    };

    var btnVerMapa = document.querySelector('#btn-ver-mapa');
    btnVerMapa.onclick = function () {
        //var lat = btnVerMapa.getAttribute('data-lat');
        //var lng = btnVerMapa.getAttribute('data-lng');
	    var endereco = btnVerMapa.getAttribute('data-endereco');

        Modal.show(endereco);
        return false;
    };

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js"></script>