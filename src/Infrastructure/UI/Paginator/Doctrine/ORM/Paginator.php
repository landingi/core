<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM;

use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;

class Paginator implements \Landingi\Shared\Infrastructure\UI\Paginator
{
    private $paginator;
    private $page;

    public function __construct(OrmPaginator $paginator, Page $page)
    {
        $this->paginator = $paginator;
        $this->page = $page;
    }

    public function getItems() : array
    {
        return (array) $this->paginator->getIterator();
    }

    public function count() : int
    {
        return $this->paginator->count();
    }

    public function getPage() : Page
    {
        return $this->page;
    }

    public function getLimit() : int
    {
        return $this->paginator->getQuery()->getMaxResults();
    }

    public function getFirstPage() : Page
    {
        return Page::firstPage();
    }

    public function getLastPage() : Page
    {
        if ($lastPage = (int) ceil($this->count() / $this->getLimit())) {
            return new Page($lastPage);
        }

        return new Page(1);
    }

    public function onLastPage() : bool
    {
        return $this->getPage()->equals($this->getLastPage());
    }
}
