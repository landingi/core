<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Landingi\Shared\Infrastructure\UI\Paginator;

class InMemoryPaginator implements Paginator
{
    private $results;
    private $page;
    private $limit;

    public function __construct($results, $page, $limit = 5)
    {
        $this->results = $results;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getItems() : array
    {
        return \array_slice($this->results, 0, $this->limit, true);
    }

    public function getPage() : Page
    {
        return new Page($this->page);
    }

    public function getLimit() : int
    {
        return $this->limit;
    }

    public function count() : int
    {
        return \count($this->results);
    }

    public function onLastPage() : bool
    {
        return $this->getPage()->equals(
            new Page($this->getLastPage())
        );
    }

    public function getLastPage() : int
    {
        return (int) ceil($this->count() / $this->getLimit()) ?: 1;
    }
}
