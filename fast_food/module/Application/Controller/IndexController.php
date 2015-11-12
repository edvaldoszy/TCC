<?php

namespace Application\Controller;

use Application\Model\PedidoModel;
use Application\View\ApplicationView;
use Szy\Http\Request;

class IndexController extends AdminController
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $this->response->sendRedirect('/pedidos/abertos');
    }
}
