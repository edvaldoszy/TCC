<?php

namespace Szy\Html;

class HtmlElement implements Element
{
    const ATTR_VALUE = "value";

    /**
     * Tag of element
     * @var string $tag
     */
    protected $tag;

    /**
     * @var bool
     */
    protected $empty;

    /**
     * Parent element
     * @var Element parent
     */
    private $parent;

    /**
     * Element attributes
     * @var array $attributes
     */
    private $attributes = array();

    /**
     * Element events
     * @var array $events
     */
    private $events = array();

    /**
     * Element children
     *
     * @var array $children
     */
    private $children = array();

    /**
     * @param string $tag
     * @param bool|false $empty
     */
    public function __construct($tag, $empty = false)
    {
        $this->tag = strtolower($tag);
        $this->empty = $empty;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * @param string $event
     * @param string $callback
     */
    public function setEvent($event, $callback)
    {
        $this->events[$event] = $callback;
    }

    /**
     * @param Element $child
     */
    public function appendChild(Element $child)
    {
        $child->setParent($this);
        $this->children[] = $child;
    }

    /**
     * @return Element
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Element $parent
     */
    public function setParent(Element $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    protected function buildParameters()
    {
        $attr = "";
        foreach ($this->attributes as $n => $v) {
            $attr .= " {$n}=\"{$v}\"";
        }

        $evt = "";
        foreach ($this->events as $n => $v) {
            $evt .= " {$n}=\"{$v}\"";
        }

        return "{$attr}{$evt}";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $parameters = $this->buildParameters();

        if ($this->empty) {
            return "<{$this->tag}{$parameters} />";
        } else {

            $inner = "";
            foreach ($this->children as $child) {
                $inner .= "{$child}";
            }

            return "<{$this->tag}{$parameters}>{$inner}</{$this->tag}>";
        }
    }
} 