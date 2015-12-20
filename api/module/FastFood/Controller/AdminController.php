<?php

namespace FastFood\Controller;

use Szy\Mvc\Controller\AbstractController;

abstract class AdminController extends AbstractController
{
    protected $cliente;

    public function init()
    {
        if (!$this->logado() && $_SERVER['SERVER_ADDR'] == $_SERVER['REMOTE_ADDR']) {
            $this->response->setStatus(401);
            exit('Unauthorized');
        }
        $this->cliente = $this->getSession()->read('cliente');
    }

    /**
     * @return boolean
     */
    protected function logado()
    {
        return $this->getSession()->exists('cliente');
    }
}
