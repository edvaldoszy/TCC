<?php

namespace FastFood\Model;

use Szy\Mvc\Model\AbstractModel;
use Szy\Mvc\Model\ModelException;

class ClienteModel extends AbstractModel
{
    public function cliente($codigo)
    {
        if (empty($codigo))
            throw new ModelException('Codigo deve ter um valor inteiro');

        $stmt = $this->query("SELECT * FROM cliente WHERE codigo = ?", array($codigo));
        $row = $stmt->fetchObject();
        unset($row->senha);
        return $row;
    }

    public function cidade($codigo)
    {
        if (empty($codigo))
            throw new ModelException('Codigo deve ter um valor inteiro');

        $stmt = $this->query("SELECT * FROM cidade WHERE codigo = ?", array($codigo));
        return $stmt->fetchObject();
    }

    public function contatos($cliente)
    {
        if (empty($cliente))
            throw new ModelException('Cliente deve ter um valor');

        $stmt = $this->query("SELECT * FROM contato WHERE cliente = ?", array($cliente->codigo));

        $res = new \ArrayIterator();
        while ($row = $stmt->fetchObject())
            $res->append($row);

        return $res->getArrayCopy();
    }

    public function endereco($cliente, $codigoEndereco)
    {
        $stmt = $this->query("SELECT * FROM endereco WHERE codigo = ? AND cliente = ?", array($cliente->codigo, $codigoEndereco));
        return $stmt->fetchObject();
    }

    public function enderecos($cliente)
    {
        if (empty($cliente))
            throw new ModelException('Cliente deve ter um valor');

        $stmt = $this->query("SELECT * FROM endereco WHERE cliente = ?", array($cliente->codigo));

        $res = new \ArrayIterator();
        while ($row = $stmt->fetchObject()) {
            $row->cidade = $this->cidade($row->cidade);
            $res->append($row);
        }
        return $res->getArrayCopy();
    }

    public function verificar($email, $senha)
    {
        $stmt = $this->query("SELECT * FROM cliente WHERE email = ? AND senha = ?", array($email, $senha));
        if ($stmt->rowCount() < 1)
            throw new ModelException('E-mail ou senha inválida');

        return $stmt->fetchObject();
    }
}