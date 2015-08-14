<?php

namespace Szy\Mvc\View;

interface View
{
    public function setValue($name, $values);

    public function __toString();
} 