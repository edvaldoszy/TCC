<?php

namespace Application\Controller;

use Eventviva\ImageResize;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\View\View;

class ImageController extends AbstractController
{
    /**
     * @return View
     */
    public function indexAction()
    {
        $w = $this->request->getParam('w');
        $h = $this->request->getParam('h');

        $path = PUBLIC_PATH . '/upload/' . $this->getParam('path');
        $image = new ImageResize($path);
        if (!empty($w) && !empty($h))
            $image->crop($w, $h, true);

        $image->output();
    }
}