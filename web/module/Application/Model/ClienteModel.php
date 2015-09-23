<?php

namespace Application\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;

class ClienteModel extends AbstractModel
{
	protected $table = 'cliente';

	/**
	 * @param ResultSet $rs
	 * @return mixed
	 */
	protected function createObject(ResultSet $rs)
	{

	}

    public function inserir(Cliente $cliente)
    {
        $this->insert($this->table, array(
            'nome' => $cliente->getNome(),
            'email' => $cliente->getEmail(),
            'senha' => $cliente->getSenha()
        ));
        $cliente->setCodigo($this->lastID('codigo'));
    }
}