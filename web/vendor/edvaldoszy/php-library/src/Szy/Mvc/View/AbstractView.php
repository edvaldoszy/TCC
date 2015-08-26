<?php

namespace Szy\Mvc\View;

use Szy\Http\Response;

defined("VIEW_PATH") or exit("VIEW_PATH not defined");

class AbstractView implements View
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
    private $layout = "default";

    /**
     * @var string
     */
    protected $language = "Pt-BR";

    /**
     * @var string
     */
    protected $charset = "UTF-8";

    /**
     * @var string
     */
    protected $title = "Home";

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @param Response $response
     * @param string $view
     * @param string $layout
     */
    public function __construct(Response $response, $view, $layout = "default")
    {
        $this->response = $response;
        $this->view = $view;
        $this->layout = $layout;
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
        include_once(VIEW_PATH . "/{$this->view}.phtml");
    }

    /**
     * @return void
     */
    public function flush()
    {
        ob_start();
        include_once(VIEW_PATH . "/layout/{$this->layout}.phtml");
        $this->response->clean();
        $this->response->write(ob_get_contents());
        ob_end_clean();
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }
}