<?php

namespace Szy\Mvc\View;

use Szy\File\FileSystem;
use Szy\Util\Date;

defined("VIEW_PATH") or exit("Necessario definir a constante VIEWPATH no arquivo");

abstract class AbstractView implements View
{
    /**
     * @var string
     */
    private $view;

    /**
     * @var string
     */
    private $layout;

    /**
     * @var string
     */
    protected $language = 'Pt-BR';

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
    protected $values;

    /**
     * @param string $view
     * @param string $layout
     * @throws Exception\ViewException
     */
    public function __construct($view, $layout = 'default')
    {
        $this->view = VIEW_PATH . "/{$view}.phtml";
        if (FileSystem::isFile($this->view) === false)
            throw new Exception\ViewException;("View file not found");

        $this->layout = VIEW_PATH . "/layout/{$layout}.phtml";
        if (FileSystem::isFile($this->layout) === false)
            throw new Exception\ViewException("Layout file not found");

        $this->values = array();
    }

    /**
     * @param string $date
     * @return string
     */
    public function en2pt($date)
    {
        $date = new Date($date);
        return $date->format("d/m/Y");
    }

    /**
     * @param string $date
     * @return string
     */
    public function pt2en($date)
    {
        $date = new Date($date);
        return $date->format("Y-m-d");
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
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        extract($this->values, EXTR_OVERWRITE);
        include_once $this->view;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return "http://{$_SERVER['SERVER_NAME']}/";
    }

    /**
     * @return array
     */
    public function getValue($name)
    {
        return isset($this->values[$name]) ? $this->values[$name] : null;
    }

    /**
     * @param string $name
     * @param mixed $values
     */
    public function setValue($name, $values)
    {
        $this->values[$name] = $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        /* Turn on output buffering */
        ob_start();
        include $this->layout;

        /** @var string $content get include contents */
        $content = ob_get_contents();
        ob_end_clean();

        /* Return content to browser */
        return $content;
    }
} 