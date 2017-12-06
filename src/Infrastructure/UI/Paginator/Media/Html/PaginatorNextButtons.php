<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator\Page;

class PaginatorNextButtons
{
    private $paginator;

    public function __construct(HtmlPaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function __toString()
    {
        if ($this->paginator->onLastPage()) {
            return '';
        }

        return sprintf(
            '<li class="next"><a href="?page=%s">%s</a></li><li class="last"><a href="?page=%s">%s</a></li>',
            $this->paginator->getNextPage(),
            '<i class="fa fa-chevron-right"></i>',
            new Page($this->paginator->getLastPage()),
            str_repeat('<i class="fa fa-chevron-right"></i>', 2)
        );
    }
}
