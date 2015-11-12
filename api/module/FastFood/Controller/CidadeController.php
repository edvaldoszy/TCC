<?php

namespace FastFood\Controller;

use FastFood\Helper\JSONResponse;
use FastFood\Model\ClienteModel;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\View\View;

class CidadeController extends AbstractController
{
    public function indexAction()
    {
        $model = new ClienteModel();

        $json = new JSONResponse($this);
        $json->set('cidades', $model->select('cidade'));

        $json->flush();
    }
}