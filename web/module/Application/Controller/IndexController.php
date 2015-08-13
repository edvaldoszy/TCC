<?php

namespace Application\Controller;

use Application\View\ApplicationView;
use Szy\Mvc\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        return new ApplicationView("home/index");
    }

    public function __call($action, $param)
    {
        var_dump($action, $param);
    }
} 