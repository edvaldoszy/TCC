<?php

namespace Application\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;
use Szy\Util\Math;

class ClienteModel extends AbstractModel
{
	protected $table = 'cliente';

    public function listar($pagina, $limite = 20)
    {
        $offset = ($pagina > 1) ? (Math::abs($pagina - 1) * $limite) : 0;
        return $this->select('cliente', null, null, null, null, $limite, $offset);
    }

    /**
	 * @param ResultSet $rs
	 * @return mixed
	 */
	protected function createObject(ResultSet $rs)
	{
        $cliente = new Cliente($rs->getInt('codigo'));
        $cliente->setNome($rs->getString('nome'));
        $cliente->setEmail($rs->getString('email'));
        $cliente->setSenha($rs->getString('senha'));

        return $cliente;
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

    public function alterar(Cliente $cliente)
    {
        $this->update($this->table, array(
            'nome' => $cliente->getNome(),
            'email' => $cliente->getEmail(),
            'senha' => $cliente->getSenha()
        ), 'codigo = ?', array($cliente->getCodigo()));
    }

    public function info($codigo)
    {
        return $this->row('cliente', null, 'codigo = ?', array($codigo));
    }
}