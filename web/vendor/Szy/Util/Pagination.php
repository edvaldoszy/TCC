<?php

namespace BLZ\Util;

use BLZ\Html\HtmlElement;
use BLZ\Html\Text;

class Pagination
{
    /**
     * @var string
     */
    private $html;

    public function __construct($current, $total, $max, $path, $qs)
    {
        if ($current < 0) $current = 0;
        $pages = floor($total / $max);
        $div = new HtmlElement("div");
        $div->setAttribute("class", "pagination");

        $prev = new HtmlElement("a");
        $prev->setAttribute("class", "btn pag-prev");
        if ($current != 0)
            $prev->setAttribute("href", "{$path}?p=" . ($current > 1 ? ($current - 1) : 0) . "&{$qs}");

        $prev->appendChild(new Text("Anterior"));
        $div->appendChild($prev);

        for ($n = 0; $n <= $pages; $n++) {
            $link = new HtmlElement("a");
            $link->setAttribute("class", "btn");
            if ($n != $current)
                $link->setAttribute("href", "{$path}?p={$n}&{$qs}");

            $link->appendChild(new Text($n + 1));
            $div->appendChild($link);
        }

        $next = new HtmlElement("a");
        $next->setAttribute("class", "btn pag-next");
        if ($current != $pages)
            $next->setAttribute("href", "{$path}?p=" . ($current < $pages ? ($current + 1) : $pages) . "&{$qs}");

        $next->appendChild(new Text("Próximo"));
        $div->appendChild($next);

        $this->html = "<hr><style>.pagination .btn{ margin-right: 4px; }</style><div class=\"default-padding\">{$div}</div>";
    }

    public function __toString()
    {
        return "{$this->html}";
    }
}