<?php

namespace Szy\Mvc\View;

use Szy\Http\Response;

defined('VIEW_PATH') or exit('VIEW_PATH not defined');

abstract class AbstractView implements View
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var string
     */
    private $view;

    /**
     * @var string
     */
    private $layout = 'default';

    /**
     * @var string
     */
    protected $language = 'pt-BR';

    /**
     * @var string
     */
    protected $charset = 'UTF-8';

    /**
     * @var string
     */
    protected $title = 'Home';

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @param Response $response
     * @param string $view
     * @param string $layout
     * @throws ViewException
     */
    public function __construct(Response $response, $view = 'home', $layout = 'default')
    {
        $view = VIEW_PATH . "/{$view}.php";
        if (!file_exists($view))
            throw new ViewException('View file does not exists');

        $layout = VIEW_PATH . "/layout/{$layout}.php";
        if (!file_exists($layout))
            throw new ViewException('Layout file does not exists');

        $this->response = $response;
        $this->view = $view;
        $this->layout = $layout;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * include body file
     */
    protected function getBody()
    {
        include_once($this->view);
    }

    /**
     * @return void
     */
    public function flush()
    {
        ob_start();
        include_once($this->layout);
        $this->response->clean();
        $this->response->write(ob_get_contents());
        ob_end_clean();
    }
}