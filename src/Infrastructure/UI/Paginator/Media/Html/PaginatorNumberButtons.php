<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator\PageRange;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;

class PaginatorNumberButtons
{
    private $paginator;

    public function __construct(HtmlPaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function __toString()
    {
        return (string) array_reduce(
            $this->getPageRange(),
            function ($carry, Page $page) {
                return sprintf(
                    '%s<li class="%s"><a href="?page=%s">%s</a></li>',
                    $carry,
                    $page->equals($this->paginator->getPage()) ? 'active' : '',
                    $page->toNumber(),
                    $page->toNumber()
                );
            },
            ''
        );
    }

    private function getPageRange() : array
    {
        return array_map(
            function ($number) {
                return new Page($number);
            },
            PageRange::fromHtmlPaginator($this->paginator)->getPages()
        );
    }
}
