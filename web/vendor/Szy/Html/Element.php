<?php

namespace Szy\Html;

interface Element
{
    const ATTR_ID = "id";

    const ATTR_CLASS = "class";

    /**
     * @param Element $child
     */
    public function appendChild(Element $child);

    /**
     * Set parent element
     *
     * @param Element $parent
     * @return void
     */
    public function setParent(Element $parent);

    /**
     * Set an attribute name and value
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function setAttribute($name, $value);

    /**
     * Get a element attribute
     *
     * @param string $name
     * @return string
     */
    public function getAttribute($name);

    /**
     * @return string
     */
    public function __toString();
}