<?php

namespace Administrator\Controller;

use Administrator\View\AdministratorView;

class IndexController extends AdministratorController
{
    public function indexAction()
    {
        $view = new AdministratorView("home/index");
        $view->setTitle("Início");
        return $view;
    }
}