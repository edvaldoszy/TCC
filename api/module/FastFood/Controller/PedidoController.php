<?php

namespace FastFood\Controller;

use Exception;
use FastFood\Helper\JSONResponse;
use FastFood\Model\ClienteModel;
use FastFood\Model\PedidoModel;
use FastFood\Model\ProdutoModel;
use Szy\Http\Request;
use Szy\Mvc\Controller\AbstractController;

class PedidoController extends AbstractController
{
    public function indexAction($codigo = null)
    {
        $model = new PedidoModel();
        if ($this->isMethod(Request::METHOD_DELETE)) {
            $pedido = $model->row('pedido', null, 'codigo = ?', array($codigo));
            if ($pedido == null) {
                $this->response->setStatus(400);
                return;
            }

            if ($pedido->dt_producao != null && $pedido->dt_producao != '0000-00-00 00:00:00') {
                $this->response->setStatus(406);
                return;
            }

            try {
                $model->delete('pedido_item', 'pedido = ?', array($codigo));
                $model->delete('pedido_produto', 'pedido = ?', array($codigo));
                $model->delete('pedido', 'codigo = ?', array($codigo));
            } catch (Exception $ex) {
                $this->response->setStatus(500, $ex->getMessage());
                return;
            }

            $this->response->setStatus(200);
            return;
        }

        if (!$this->isMethod(Request::METHOD_POST)) {
            $this->response->setStatus(400);
            return;
        }

        $data = $this->getPost('data');
        $json = json_decode($data);

        $dataAtual = (new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')))->format('Y-m-d H:i:s');
        try {
            $pedido = $json->pedido;

            // Verifica se o usuário está alterando o pedido
            $alterar = (isset($pedido->codigo) && !empty($pedido->codigo));

            $valores_pedido = array(
                'valor' => $pedido->valor,
                'pagamento' => $pedido->pagamento,
                'troco' => $pedido->troco,
                'endereco' => json_encode($pedido->endereco),
                'lat' => $pedido->endereco->lat,
                'lng' => $pedido->endereco->lng,
                'dt_aberto' => $dataAtual,
                'situacao' => $pedido->situacao,
                'cliente' => $pedido->cliente->codigo,
                'usuario' => null
            );

            if ($alterar) {
                $model->update('pedido', $valores_pedido, 'codigo = ?', array($pedido->codigo));
            } else {
                $model->insert('pedido', $valores_pedido);
                $pedido->codigo = $model->lastID('codigo');
            }

            // Veriável código serve para diferenciar caso eu tenha dois produtos do mesmo tipo em um mesmo pedido
            foreach ($json->detalhes as $detalhe) {

                $produto = $detalhe->produto;
                $valores_produto = array(
                    'pedido' => $pedido->codigo,
                    'produto' => $produto->codigo,
                    'quantidade' => $detalhe->quantidade,
                    'valor' => $detalhe->valor
                );

                if ($alterar) {
                    $model->update('pedido_produto', $valores_produto, 'pedido = ? AND produto = ?', array($pedido->codigo, $produto->codigo));
                } else {
                    $model->insert('pedido_produto', $valores_produto);
                    $detalhe->codigo = $model->lastID('codigo');
                }

                $itens = $detalhe->itens;
                foreach ($itens as $item) {
                    $valores_item = array(
                        'codigo'=> $detalhe->codigo,
                        'pedido' => $pedido->codigo,
                        'produto' => $produto->codigo,
                        'item' => $item->codigo,
                        'quantidade' => $item->quantidade,
                        'adicional' => intval($item->adicional),
                        'valor' => $item->valor
                    );

                    if ($alterar) {
                        $model->update('pedido_item',
                            $valores_item, 'pedido = ? AND produto = ? AND item = ?',
                            array($pedido->codigo, $produto->codigo, $item->codigo));

                    } else {
                        $model->insert('pedido_item', $valores_item);
                        $item->codigo = $model->lastID('codigo');
                    }
                }
            }

            $out = array('pedido' => $pedido);
            $this->response->write(json_encode($out));
        } catch (Exception $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        }
    }

    public function abertosAction($codigo) {

        $situacao = $this->getParam('situacao', FILTER_SANITIZE_NUMBER_INT);
        if ($situacao == null)
            $situacao = PedidoModel::ABERTO;

        $modelCliente = new ClienteModel();
        $cliente = $modelCliente->cliente($codigo);

        $modelPedido = new PedidoModel();
        $pedidos = $modelPedido->pedidos($cliente, $situacao);
        
        $json = new JSONResponse($this);
        unset($cliente->imagem);
        $json->set('cliente', $cliente);
        $json->set('pedidos', $pedidos);

        $json->flush();
    }

    public function detalhesAction($codigo)
    {
        $json = new JSONResponse($this);

        $model = new PedidoModel();
        $pedido = $model->row('pedido', null, 'codigo = ?', array($codigo));
        if ($pedido == null) {
            $this->response->setStatus(500, 'Codigo do pedido invalido');
            return;
        }

        try {
            $detalhes = $model->produtos($pedido);
            $json->set('detalhes', $detalhes);
        } catch (Exception $ex) {
            $this->response->setStatus(500, $ex->getMessage());
        }

        $json->flush();
    }

    public function verificarAction($codigo = null)
    {
        $model = new PedidoModel();
        $pedido = $model->row(
            'pedido',
            null,
            'dt_fechado IS NOT NULL AND situacao = 2 AND codigo = ?',
            array($codigo),
            'codigo DESC'
        );

        if ($pedido == null) {
            $this->response->write('NO');
        } else {
            $this->response->write('OK');
        }
    }

    public function produtosAction($codigo = null)
    {
        $model = new PedidoModel();
        $pedido = $model->row('pedido', null, 'codigo = ?', array($codigo));
        if ($pedido == null) {
            $this->response->setStatus(400);
            return;
        }

        $out = array(
            'cliente' => array('codigo' => intval($pedido->cliente)),
            'produtos' => $model->produtosClassificacao($pedido)
        );

        $this->response->setStatus(200);
        $this->response->write(json_encode($out));
    }
}