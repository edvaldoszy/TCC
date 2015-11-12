<?php

namespace Application\Helper;

use Szy\Html\HtmlElement;

class HtmlUploadImages
{
    /**
     * @var array
     */
    private $images;

    /**
     * @var string
     */
    private $html;

    public function __construct($images = null)
    {
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (count($this->images) < 1)
            return "";

        $div = new HtmlElement('div');
        foreach ($this->images as $src) {
            $img = new HtmlElement('img', true);
            $img->setAttribute('src', "{$src}?w=170&h=120");
            $div->appendChild($img);
        }

        return strval($div);
    }
}