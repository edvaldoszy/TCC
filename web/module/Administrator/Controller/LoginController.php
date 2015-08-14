<?php

namespace Administrator\Controller;

use Administrator\View\AdministratorView;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\View\View;

class LoginController extends AbstractController
{
    /**
     * Default controller action
     *
     * @return View
     */
    public function indexAction()
    {
        $login = $this->getPost('login', FILTER_SANITIZE_STRING);
        $senha = $this->getPost('senha', FILTER_SANITIZE_STRING);


        return new AdministratorView('login/index');
    }

}