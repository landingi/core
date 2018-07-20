<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media;

use Landingi\Shared\Infrastructure\UI\Paginator;

class MediaPaginator
{
    protected $paginator;

    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function getPrevPage() : Paginator\Page
    {
        return $this->getPage()->prevPage();
    }

    public function getNextPage() : Paginator\Page
    {
        return $this->getPage()->nextPage();
    }

    public function getPage() : Paginator\Page
    {
        return $this->paginator->getPage();
    }

    public function onFirstPage() : bool
    {
        return $this->paginator->onFirstPage();
    }

    public function onLastPage() : bool
    {
        return $this->paginator->onLastPage();
    }
}
