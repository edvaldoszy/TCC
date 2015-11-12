<?php

namespace Application\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;
use Szy\Util\Math;

class UsuarioModel extends AbstractModel
{
    /**
     * @param ResultSet $rs
     * @return mixed
     */
    protected function createObject(ResultSet $rs)
    {
        // TODO: Implement createObject() method.
    }

    public function listar($pagina, $limite = 20)
    {
        $offset = ($pagina > 1) ? (Math::abs($pagina - 1) * $limite) : 0;
        return $this->select('usuario', null, null, null, 'nome ASC', $limite, $offset);
    }
}