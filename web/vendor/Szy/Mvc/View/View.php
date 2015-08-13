<?php

namespace Szy\Mvc\View;

interface View
{
    public function setAttribute($name, $value);

    public function setValue($name, $values);

    public function __toString();
} 