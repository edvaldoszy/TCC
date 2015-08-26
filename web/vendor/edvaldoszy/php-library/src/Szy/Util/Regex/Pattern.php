<?php

namespace Szy\Util\Regex;

class Pattern
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $pattern = trim($pattern);
        if (empty($pattern))
            throw new \InvalidArgumentException('Pattern cannot be null');

        $this->pattern = $pattern;
    }

    /**
     * @param string $text
     * @param $matches
     * @param bool $global
     * @return bool
     */
    public function match($text, &$matches = null, $global = false)
    {
        $text = trim($text);
        if (empty($text))
            throw new \InvalidArgumentException('Text cannot be null');

        if ($global)
            return boolval(preg_match_all($this->pattern, $text, $matches));
        else
            return boolval(preg_match($this->pattern, $text, $matches));
    }


    /**
     * @param string $replace
     * @param string $text
     * @param int $limit
     * @return string
     */
    public function replace($replace, $text, $limit = -1)
    {
        $text = trim($text);
        if (empty($text))
            throw new \InvalidArgumentException('Text cannot be null');

        return strval(preg_replace($this->pattern, $replace, $text, $limit));
    }

    /**
     * @param string $text
     * @param int $limit
     * @return string
     */
    public function split($text, $limit = -1)
    {
        $text = trim($text);
        if (empty($text))
            throw new \InvalidArgumentException('Text cannot be null');

        return strval(preg_split($this->pattern, $text, $limit));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->pattern;
    }
}