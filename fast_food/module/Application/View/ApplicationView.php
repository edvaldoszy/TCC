<?php

namespace Application\View;

use Application\Helper\Message;
use Szy\Mvc\Application;
use Szy\Mvc\View\AbstractView;

define('VIEW_PATH', __DIR__);

class ApplicationView extends AbstractView
{
    /**
     * @param Message $message
     */
    public function setMessage(Message $message)
    {
        $this->setAttribute('message', $message);
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->getAttribute('message');
    }

    public function url($path = null)
    {
        $server = Application::getConfig('server_name');
        if (!empty($path))
            return $server . $path;

        return $server;
    }
}