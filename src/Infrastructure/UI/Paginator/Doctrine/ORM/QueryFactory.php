<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM;

use Doctrine\ORM\Query;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryOffset;

class QueryFactory
{
    public function build(Query $query, Page $page, QueryLimit $limit) : Query
    {
        $query->setFirstResult($this->buildOffset($page, $limit)->toNumber());
        $query->setMaxResults($limit->toNumber());

        return $query;
    }

    private function buildOffset(Page $page, QueryLimit $limit) : QueryOffset
    {
        return new QueryOffset($page, $limit);
    }
}
