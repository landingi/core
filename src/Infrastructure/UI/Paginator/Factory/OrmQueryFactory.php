<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Factory;

use Doctrine\ORM\Query;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryOffset;

class OrmQueryFactory
{
    private $query;
    private $page;
    private $limit;

    public function __construct(Query $query, Page $page, QueryLimit $limit)
    {
        $this->query = $query;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function buildQueryWithDelimeters() : Query
    {
        $this->query->setFirstResult(
            (new QueryOffset($this->page, $this->limit))->toNumber()
        );
        $this->query->setMaxResults($this->limit->toNumber());

        return $this->query;
    }
}
