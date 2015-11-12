<?php

namespace Application\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;

class EnderecoModel extends AbstractModel
{
    /**
     * @param ResultSet $rs
     * @return object
     */
    protected function createObject(ResultSet $rs)
    {
        $endereco = new Endereco();
        $endereco->setCodigo($rs->getInt('codigo'));
        $endereco->setLogradouro($rs->getString('logradouro'));
        $endereco->setNumero($rs->getString('numero'));
        $endereco->setBairro($rs->getString('bairro'));
        $endereco->setLat($rs->getString('lat'));
        $endereco->setLng($rs->getString('lng'));

        $cidadeModel = new CidadeModel();
        $endereco->setCidade($cidadeModel->row('cidade', null, 'codigo = ?', array($rs->getInt('cidade'))));

        $clienteModel = new ClienteModel();
        $endereco->setCliente($clienteModel->row('cliente', null, 'codigo = ?', array($rs->getInt('cliente'))));

        return $endereco;
    }

    public function inserir(Endereco $endereco)
    {
        $this->insert($this->table, array(
            'logradouro' => $endereco->getLogradouro(),
            'numero' => $endereco->getNumero(),
            'bairro' => $endereco->getBairro(),
            'lat' => $endereco->getLat(),
            'lng' => $endereco->getLng(),
            'cidade' => $endereco->getCidade()->getCodigo(),
            'cliente' => $endereco->getCliente()->getCodigo()
        ));
    }
}