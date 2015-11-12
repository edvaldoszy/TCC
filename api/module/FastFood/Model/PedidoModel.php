<?php

namespace FastFood\Model;

use Szy\Mvc\Model\AbstractModel;

class PedidoModel extends AbstractModel
{
    public function cadastrar($detalhes)
    {
        $this->insert('pedido', array());
    }
}