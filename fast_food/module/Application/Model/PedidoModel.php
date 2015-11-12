<?php

namespace Application\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;

class PedidoModel extends AbstractModel
{
    public static $FORMAS_PAGAMENTO = array(
        '1' => 'Dinheiro',
        '2' => 'Cartão'
    );

    public function pedidosAbertos()
    {
        $stmt = $this->query("SELECT pe.*, cl.nome AS cliente, SUM(pp.quantidade) AS produtos FROM pedido pe
        INNER JOIN cliente cl ON (cl.codigo = pe.cliente)
        INNER JOIN pedido_produto pp ON (pp.pedido = pe.codigo)
        WHERE pe.situacao = 1
        GROUP BY pe.codigo ORDER BY pe.codigo DESC");

        $res = new \ArrayIterator();
        while ($row = $stmt->fetchObject()) {

            switch ($row->pagamento) {
                case '1':
                    $row->str_pagamento = sprintf('Dinheiro (%s)', ($row->troco < 1 ? 'sem troco' : "troco para R$ {$row->troco}"));
                    break;

                case '2':
                    $row->str_pagamento = 'Cartão';
                    break;
            }

            $res->append($row);
        }

        return $res->getArrayCopy();
    }

    /**
     * @param int $codigo
     * @return array
     */
    public function detalhes($codigo)
    {
        $pedido = $this->row('pedido', null, 'codigo = ?', array($codigo));
        $pedido->cliente = $this->row('cliente', array('nome'), 'codigo = ?', array($pedido->cliente));

        $pedido->str_pagamento = PedidoModel::$FORMAS_PAGAMENTO[$pedido->pagamento];
        if ($pedido->pagamento == '1' && !empty($pedido->troco) && $pedido->troco > 0) {
            $pedido->str_pagamento .= ' (troco para R$ ' . $pedido->troco . ')';
        }

        $stmt1 = $this->query("SELECT pp.* FROM pedido_produto pp
        INNER JOIN produto po ON (po.codigo = pp.produto)
        WHERE pp.pedido = ?", array($codigo));

        while($row = $stmt1->fetchObject()) {
            $row->produto = $this->row('produto', null, 'codigo = ?', array($row->produto));

            $stmt2 = $this->query("SELECT po.nome, pm.* FROM pedido_item pm
            INNER JOIN produto po ON (po.codigo = pm.item)
            WHERE pm.pedido = ? AND pm.produto = ?", array($row->pedido, $row->produto->codigo));

            while ($item = $stmt2->fetchObject()) {
                $item->valor_total = number_format($item->quantidade * $item->valor, 2);
                $row->itens[] = $item;
            }

            $pedido->detalhes[] = $row;
        }
        return $pedido;
    }
}