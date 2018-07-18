<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator;

class HtmlPaginator
{
    private $paginator;

    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function __toString()
    {
        if (1 === $this->getLastPage()) {
            return '';
        }

        return sprintf(
            '<div class="pagination-wrap"><ul class="pagination">%s%s%s</ul></div>',
            new PaginatorPreviousButtons($this),
            new PaginatorNumberButtons($this),
            new PaginatorNextButtons($this)
        );
    }

    public function onFirstPage(): bool
    {
        return $this->getPage()->equals(Paginator\Page::firstPage());
    }

    public function getPrevPage(): Paginator\Page
    {
        return $this->getPage()->prevPage();
    }

    public function getNextPage(): Paginator\Page
    {
        return $this->getPage()->nextPage();
    }

    public function getPage(): Paginator\Page
    {
        return $this->paginator->getPage();
    }

    public function getLastPage(): int
    {
        return $this->paginator->getLastPage()->toNumber();
    }

    public function onLastPage(): bool
    {
        return $this->paginator->onLastPage();
    }
}
