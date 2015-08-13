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
        $user = $this->getSession()->read('logged_user');
        if ($user == null)
            $this->redirect('/login');
    }


}