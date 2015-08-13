<?php

namespace Szy\Mvc\Controller;

use Szy\Mvc\View\View;
use Szy\Session\Storage as SessionStorage;

interface Controller
{
    /**
     * @return void
     */
    public function init();

    /**
     * Default controller action
     *
     * @return View
     */
    public function indexAction();

    /**
     * Get the current session
     *
     * @return SessionStorage
     */
    public function getSession();
} 