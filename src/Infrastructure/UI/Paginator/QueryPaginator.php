<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Landingi\Shared\Infrastructure\Doctrine\DbalQuery;
use Landingi\Shared\Infrastructure\UI\Paginator;

class QueryPaginator implements Paginator
{
    private $result;
    private $limit;
    private $page;

    public function __construct(DbalQuery $query, int $page, int $limit = 10)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->result = new QueryResult($query, $this->limit, ($this->page - 1) * $this->limit);
    }

    public function getPage(): Paginator\Page
    {
        return new Paginator\Page($this->page);
    }

    public function getItems(): array
    {
        return $this->result->getItems();
    }

    public function count(): int
    {
        return $this->result->getTotal();
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
