<?php

namespace Application\View;

use Application\Helper\Message;
use Szy\Mvc\Application;
use Szy\Mvc\View\AbstractView;
use Szy\Util\DateTime;

define('VIEW_PATH', __DIR__);

class ApplicationView extends AbstractView
{
    public function url($path = null)
    {
        $server = Application::getConfig('server_name');
        if (!empty($path))
            return $server . $path;

        return $server;
    }

    public function formatar_data($data) {

        if (empty($data) || $data == '0000-00-00 00:00:00')
            return '---';

        $data = new DateTime($data);
        return $data->format('d/m/Y H:i:s');
    }
}