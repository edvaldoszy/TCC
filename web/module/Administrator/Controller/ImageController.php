<?php

namespace Administrator\Controller;

use Eventviva\ImageResize;
use Szy\Mvc\Controller\AbstractController;
use Szy\Mvc\View\View;

class ImageController extends AbstractController
{
    /**
     * Default controller action
     *
     * @return View
     */
    public function indexAction() {}

    public function cropAction()
    {
        $path = $this->getParam("path");
        $width = intval($this->getParam("w", FILTER_SANITIZE_NUMBER_INT));
        $height = intval($this->getParam("h", FILTER_SANITIZE_NUMBER_INT));

        $image = new ImageResize(BASE_PATH . "/public_html/{$path}");
        if ($width && $height)
            $image->crop($width, $height);

        $image->output();
    }
}