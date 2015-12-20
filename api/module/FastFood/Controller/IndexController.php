<?php

namespace FastFood\Controller;

class IndexController extends AdminController
{
    public function indexAction()
    {
        $this->response->write('index');
    }
}