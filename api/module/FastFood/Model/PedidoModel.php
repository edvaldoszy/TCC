<?php

namespace FastFood\Model;

use Szy\Mvc\Model\AbstractModel;
use Szy\Mvc\Model\ModelException;

class PedidoModel extends AbstractModel
{
    const ABERTO = '1';
    const PRODUCAO = '3';
    const FECHADO = '2';

    public function cadastrar($detalhes)
    {
        $this->insert('pedido', array());
    }

    public function pedidos($cliente, $situacao = self::FECHADO)
    {
        $sql = 'SELECT pe.*, SUM(pp.quantidade) AS produtos FROM pedido pe
        INNER JOIN cliente cl ON (cl.codigo = pe.cliente)
        INNER JOIN pedido_produto pp ON (pp.pedido = pe.codigo)
        WHERE (pe.situacao = ? OR pe.situacao = ?) AND pe.cliente = ?
        GROUP BY pe.codigo ORDER BY pe.codigo DESC';

        $args = array(
            ($situacao == self::FECHADO ? self::FECHADO : self::ABERTO),
            ($situacao == self::FECHADO ? self::FECHADO : self::PRODUCAO),
            $cliente->codigo
        );

        $stmt = $this->query($sql, $args);
        $res = $stmt->fetchAll();
        for ($n = 0; $n < count($res); $n++) {
            $row = &$res[$n];
            $row->endereco = json_decode($row->endereco);
            $row->cliente = $this->row('cliente', null, 'codigo = ?', array($row->cliente));
        }

        return $res;
    }

    public function produtos($pedido)
    {
        $sql = 'SELECT po.*, pp.produto, pp.quantidade, pp.valor FROM pedido_produto pp
        INNER JOIN produto po ON (po.codigo = pp.produto)
        WHERE pp.pedido = ? AND po.tipo = 2';

        $stmt = $this->query($sql, array($pedido->codigo));

        $res = array();
        $modelProduto = new ProdutoModel();
        while ($row = $stmt->fetchObject()) {

            $detalhe = new \StdClass();
            $detalhe->produto = $modelProduto->produto($row->codigo);
            $detalhe->quantidade = $row->quantidade;
            $detalhe->valor = $row->valor;

            /*
            $stmt1 = $this->query('SELECT po.*, pi.quantidade, pi.adicional FROM pedido_item pi
            INNER JOIN produto po ON (po.codigo = pi.item)
            WHERE pi.pedido = ? AND pi.produto = ? AND po.tipo = 1');
            while ($pi = $stmt1->fetchObject()) {
                $detalhe->itens[] = $pi;
            }
            */

            $detalhe->itens = $modelProduto->itens($detalhe->produto);

            $res[] = $detalhe;
        }

        return $res;
    }

    public function itens($pedido, $produto) {

        if ($produto == null || !isset($produto->codigo))
            throw new ModelException("Informe um produto para consulta");

        $stmt = $this->query("SELECT pt.* FROM pedido_item pt
        INNER JOIN produto po ON (po.codigo = pt.item)
        WHERE pt.pedido = ? AND po.tipo = 1 AND pt.produto = ? ORDER BY pt.adicional",

            array($pedido->codigo, $produto->codigo));

        $res = $stmt->fetchAll();
        foreach ($res as $k => $row) {
            $item = $this->produto($row->item);
            $item->quantidade = floatval($row->quantidade);
            $item->adicional = boolval($row->adicional);
            $item->valor = floatval($row->valor);
            unset($item->categoria);
            $res[$k] = $item;
        }

        return $res;
    }

    public function produto($codigo)
    {
        if (empty($codigo))
            throw new ModelException('Parametro codigo nao informado');

        $stmt = $this->query("SELECT po.*, mi.caminho AS imagem FROM produto po
        LEFT JOIN midia mi ON (mi.produto = po.codigo)
        WHERE po.codigo = ? LIMIT 1", array($codigo));

        $row = $stmt->fetchObject();
        $row->valor = floatval($row->valor);
        $row->ativo = boolval($row->ativo);
        $row->tipo = intval($row->tipo);
        $row->categoria = $this->categoria($row->categoria);

        return $row;
    }

    public function categoria($codigo)
    {
        if (empty($codigo))
            throw new ModelException('Parametro codigo nao informado');

        $stmt = $this->query("SELECT * FROM categoria WHERE codigo = ?", array($codigo));
        return $stmt->fetchObject();
    }

    public function produtosClassificacao($pedido)
    {
        $itens = $this->select('pedido_produto', null, 'pedido = ?', array($pedido->codigo));

        $res = array();
        foreach ($itens as $item) {
            $res[] = $this->produto($item->produto);
        }
        return $res;
    }
}