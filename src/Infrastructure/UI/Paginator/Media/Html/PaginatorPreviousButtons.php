<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator\Page;

class PaginatorPreviousButtons
{
    private $paginator;

    public function __construct(HtmlPaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function __toString()
    {
        if ($this->paginator->onFirstPage()) {
            return '';
        }

        return sprintf(
            '<li class="first"><a href="?page=%s">%s</a></li><li class="prev"><a href="?page=%s">%s</a></li>',
            Page::firstPage(),
            str_repeat('<i class="fa fa-chevron-left"></i>', 2),
            $this->paginator->getPrevPage(),
            '<i class="fa fa-chevron-left"></i>'
        );
    }
}
