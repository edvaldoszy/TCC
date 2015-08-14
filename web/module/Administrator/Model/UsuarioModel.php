<?php

namespace Administrator\Model;

use Szy\Mvc\Model\AbstractModel;

class UsuarioModel extends AbstractModel
{
    protected $table = 'usuario';

    /**
     * @param string $login
     * @param string $senha
     * @return bool
     */
    public function validar($login, $senha)
    {
        if (empty($login) || empty($senha))
            return false;

        $row = $this->row(array('login', 'senha'), "situacao = '1' AND login = ? AND senha = ?", array($login, $senha));
        return true;
    }
}