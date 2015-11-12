<?php

namespace FastFood\Model;

use Szy\Mvc\Model\AbstractModel;
use Szy\Mvc\Model\ModelException;

class EnderecoModel extends AbstractModel
{
    private $cliente;

    public function __construct($cliente) {
        if (empty($cliente))
            throw new ModelException("Cliente não pode ser nulo");

        $this->cliente= $cliente;
    }

    public function cidade($codigo)
    {
        if (empty($codigo))
            throw new ModelException('Codigo deve ter um valor inteiro');

        $stmt = $this->query("SELECT * FROM cidade WHERE codigo = ?", array($codigo));
        return $stmt->fetchObject();
    }

    public function endereco($codigo)
    {
        $stmt = $this->query("SELECT * FROM endereco WHERE cliente = ? LIMIT 1", array($this->cliente->codigo));
        return $stmt->fetchObject();
    }

    public function enderecos()
    {
        $stmt = $this->query("SELECT * FROM endereco WHERE cliente = ?", array($this->cliente->codigo));

        $res = new \ArrayIterator();
        while ($row = $stmt->fetchObject()) {
            $row->cidade = $this->cidade($row->cidade);
            $res->append($row);
        }
        return $res->getArrayCopy();
    }

    public function atualizar($endereco)
    {
        $fields = (array) $endereco;
        unset($fields['codigo']);

        $stmt = $this->query(sprintf('UPDATE endereco SET %s = ? WHERE codigo = ?', implode(' = ?, ', array_keys($fields))), array_values((array) $endereco));
    }
}