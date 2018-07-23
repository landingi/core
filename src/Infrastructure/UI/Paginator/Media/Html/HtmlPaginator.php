<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator;

class HtmlPaginator extends Paginator\Media\MediaPaginator
{
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

    public function getLastPage() : int
    {
        return $this->paginator->getLastPage()->toNumber();
    }
}
