<?php

namespace Application\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;

class ContatoModel extends AbstractModel
{
    private $table = 'contato';

    /**
     * @param ResultSet $rs
     * @return mixed
     */
    protected function createObject(ResultSet $rs)
    {
        $contato = new Contato($rs->getInt('codigo'));
        $contato->setTelefone($rs->getString('telefone'));

        $clienteModel = new ClienteModel();
        $contato->setCliente($clienteModel->row('cliente', null, 'codigo = ?', array($rs->getInt('cliente'))));

        return $contato;
    }

    public function inserir(Contato $contato)
    {
        $this->insert($this->table, array(
           'telefone' => $contato->getTelefone(),
            'cliente' => $contato->getCliente()->getCodigo()
        ));

        $contato->setCodigo($this->lastID('codigo'));
    }

    public function listar(Cliente $cliente)
    {
        $sql = "SELECT co.* FROM contato co WHERE co.cliente = ?";

        $rs = $this->query($sql, array($cliente->getCodigo()));
        $out = array();
        while ($rs->valid()) {
            $out[] = $this->createObject($rs);
            $rs->next();
        }

        return $out;
    }
}