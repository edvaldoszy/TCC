<?php

namespace Szy\Mvc\View;

use ArrayObject;

defined("VIEWPATH") or exit("Necessario definir a constante VIEWPATH no arquivo");

abstract class AbstractView implements View
{
    /**
     * @var string $viewFile
     */
    private $view;

    /**
     * @var string $layout
     */
    private $layout;

    /**
     * Default html language
     *
     * @var string $language
     */
    protected $language = "Pt-BR";

    /**
     * Default html charset
     *
     * @var string $charset
     */
    protected $charset = "UTF-8";

    /**
     * Page title
     *
     * @var string $title
     */
    protected $title = "Home";

    /**
     * List of css files
     * @var array $stylesheet
     */
    private $stylesheet = array();

    /**
     * List of javascript files
     *
     * @var array $javascript
     */
    private $javascript = array();

    /**
     * List of parameters
     *
     * @var array $attribute
     */
    protected $attribute = array();

    /**
     * List of values
     *
     * @var ArrayObject $values
     */
    protected $values;

    /**
     * @param string $view
     * @param string $layout
     * @throws Exception\ViewException
     */
    public function __construct($view, $layout = "default")
    {
        $this->view = sprintf("%s/%s.phtml", VIEWPATH, $view);
        if (!file_exists($this->view))
            throw new Exception\ViewException;("View file not found");

        $this->layout = sprintf("%s/layout/%s.phtml", VIEWPATH, $layout);
        if (!file_exists($this->layout))
            throw new Exception\ViewException("Layout file not found");

        $this->values = new ArrayObject();
    }

    /**
     * Retorna a linguagem do documento Html (padrão Pt-BR)
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Retorna a codificação do documento Html (padrão UTF-8)
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Adiciona um documento CSS a página
     *
     * @param $href Endereço do arquivo CSS
     * @param string $media Qual media será aplicado (padrão all)
     * @return $this
     */
    public function addStyleSheet($href, $media = "all")
    {
        $this->stylesheet[] = array(
            "href" => $href,
            "media" => $media
        );
        return $this;
    }

    /**
     * Obtem a lista de arquivos CSS adicionados
     */
    public function getStyleSheet()
    {
        $out = "";
        foreach($this->stylesheet as $stylesheet)
        {
            $out .= "<link rel=\"stylesheet\" media=\"{$stylesheet['media']}\" href=\"{$stylesheet['href']}\">\n";
        }
        echo $out;
    }

    /**
     * Adiciona o documento JavaScript a página
     *
     * @param $src Endereço do arquivo javaScript
     * @param string $type Tipo de arquivo (padrão text/javascript)
     * @return $this
     */
    public function addJavaScript($src, $type = "text/javascript")
    {
        $this->javascript[] = array(
            "src" => $src,
            "type" => $type
        );
        return $this;
    }

    /**
     * Obtem a lista de arquivos JavaScript adicionados
     */
    public function getJavaScript()
    {
        $out = "";
        foreach($this->javascript as $javascript)
        {
            $out .= "<script type=\"{$javascript['type']}\" src=\"{$javascript['src']}\"></script>\n";
        }
        echo $out;
    }

    /**
     * Modifica o título do documento
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Retorna o título do documento
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Inclui o arquivo com o conteúdo
     */
    public function getBody()
    {
        extract($this->attribute, EXTR_OVERWRITE);
        include $this->view;
    }

    /**
     * @param string $name
     * @return null|mixed
     */
    public function getAttribute($name)
    {
        return isset($this->attribute[$name]) ? $this->attribute[$name] : null;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setAttribute($name, $value)
    {
        $this->attribute[$name] = $value;
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
     * @param array $values
     */
    public function setValue($name, $values)
    {
        $this->values[$name] = $values;
    }

    /**
     * @param $date
     * @return string
     */
    public function en2pt($date)
    {
        $date = new DateTime($date);
        return $date->format("d/m/Y");
    }

    /**
     * @param $date
     * @return string
     */
    public function pt2en($date)
    {
        $date = new DateTime($date);
        return $date->format("Y-m-d");
    }

    /**
     * Retorna o conteúdo devidamente formatado para exibição no browser
     *
     * @return string
     */
    public function __toString()
    {
        ob_start(); // Ativa o buffer de saída e não mostra o conteúdo na tela
        include $this->layout;
        $content = ob_get_contents(); // Pega o conteúdo do include
        ob_end_clean();
        return $content; // Retorna o conteúdo sem mostar nada na tela
    }
} 