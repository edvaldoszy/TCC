<?php

namespace Application\Controller;

use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\View\View;

class IndexController extends AbstractController
{
    /**
     * @return View
     */
    public function indexAction()
    {
        echo "INDEX INDEX";
    }

}