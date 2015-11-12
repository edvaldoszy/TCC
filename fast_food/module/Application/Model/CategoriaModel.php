<?php

namespace Application\Model;

use Szy\Mvc\Model\AbstractModel;
use Szy\Util\Math;

class CategoriaModel extends AbstractModel
{
    public function listar($pagina, $limite = 20)
    {
        $offset = ($pagina > 1) ? (Math::abs($pagina - 1) * $limite) : 0;
        return $this->select('categoria', null, null, null, 'nome ASC', $limite, $offset);
    }
}