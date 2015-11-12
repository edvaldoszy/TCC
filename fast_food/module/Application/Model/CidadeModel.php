<?php

namespace Application\Model;

use Szy\Database\ResultSet;
use Szy\Mvc\Model\AbstractModel;

class CidadeModel extends AbstractModel
{
    /**
     * @param ResultSet $rs
     * @return mixed
     */
    protected function createObject(ResultSet $rs)
    {
        $cidade = new Cidade($rs->getInt('codigo'));
        $cidade->setNome($rs->getString('nome'));
        $cidade->setUf($rs->getString('uf'));

        return $cidade;
    }
}