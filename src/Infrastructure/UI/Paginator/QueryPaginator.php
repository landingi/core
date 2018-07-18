<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Landingi\Shared\Infrastructure\Doctrine\DbalQuery;
use Landingi\Shared\Infrastructure\UI\Paginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;

class QueryPaginator implements Paginator
{
    private $limit;
    private $page;
    private $query;

    /** For internal cache */
    private $result;

    public static function factory(DbalQuery $query, int $page, int $limit)
    {
        return new self(
            $query,
            new Paginator\Page($page),
            new QueryLimit($limit)
        );
    }

    public function __construct(DbalQuery $query, Paginator\Page $page, QueryLimit $limit)
    {
        $this->query = $query;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getPage(): Paginator\Page
    {
        return $this->page;
    }

    public function getItems(): array
    {
        return $this->getResult()->getItems();
    }

    public function count(): int
    {
        return $this->getResult()->getTotal();
    }

    public function getLimit(): int
    {
        return $this->limit->toNumber();
    }

    private function getResult()
    {
        if (!$this->result) {
            $this->result = new QueryResult(
                $this->query,
                $this->limit,
                new Paginator\Query\QueryOffset($this->page, $this->limit)
            );
        }

        return $this->result;
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
