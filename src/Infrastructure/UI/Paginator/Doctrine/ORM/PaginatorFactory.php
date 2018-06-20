<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;

class PaginatorFactory
{
    public static function build(QueryFactory $factory, Query $query, Page $page, QueryLimit $limit) : Paginator
    {
        return new Paginator(
            $factory->build(
                $query,
                $page,
                $limit
            ),
            false
        );
    }
}
