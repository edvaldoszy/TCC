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
        return new AdministratorView('login/index');
    }

}