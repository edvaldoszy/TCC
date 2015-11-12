<?php

namespace FastFood\Controller;

use FastFood\Helper\JSONResponse;
use FastFood\Model\ClienteModel;
use FastFood\Model\PedidoModel;
use Szy\Http\Request;
use Szy\Mvc\Controller\AbstractController;

class PedidoController extends AbstractController
{
    public function indexAction()
    {
        if (!$this->isMethod(Request::METHOD_POST)) {
            $this->response->setStatus(400);
            return;
        }

        $model = new PedidoModel();

        $data = $this->getPost('data');
        $json = json_decode($data);

        //var_dump($json);
        //exit;

        $pedido = $json->pedido;
        $model->insert('pedido', array(
            'valor' => $pedido->valor,
            'pagamento' => $pedido->pagamento,
            'troco' => $pedido->troco,
            'lat' => $pedido->lat,
            'lng' => $pedido->lng,
            'situacao' => $pedido->situacao,
            'cliente' => $pedido->cliente->codigo,
            'usuario' => null
        ));
        $pedido->codigo = $model->lastID('codigo');

        foreach ($json->detalhes as $detalhe) {

            $produto = $detalhe->produto;
            $model->insert('pedido_produto', array(
                'pedido' => $pedido->codigo,
                'produto' => $produto->codigo,
                'quantidade' => $detalhe->quantidade,
                'valor' => $detalhe->valor
            ));

            $itens = $detalhe->itens;
            foreach ($itens as $item) {
                $model->insert('pedido_item', array(
                    'pedido' => $pedido->codigo,
                    'produto' => $produto->codigo,
                    'item' => $item->codigo,
                    'quantidade' => $item->quantidade,
                    'valor' => $item->valor
                ));
            }
        }
    }

    public function abertos($codigo) {

        $model = new PedidoModel();

        $modelCliente = new ClienteModel();
        $cliente = $modelCliente->cliente($codigo);
        
        $json = new JSONResponse($this);

        $json->flush();
    }
}