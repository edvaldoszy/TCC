<?php

namespace Administrator\Controller;

use Szy\Mvc\Controller\AbstractController;

abstract class AdministratorController extends AbstractController
{
    /**
     * @return void
     */
    public function init()
    {
        $usuario = $this->getSession()->read('usuario_logado');

        if ($usuario == null)
            $this->redirect('/login');
    }


}