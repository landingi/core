<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Factory;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM\Paginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM\QueryFactory;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;

class PaginatorFactory
{
    private $factory;

    public function __construct(QueryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function build(Query $query, Page $page, QueryLimit $limit) : Paginator
    {
        return new Paginator(
            new OrmPaginator(
                $this->factory->build($query, $page, $limit),
                false
            ),
            $page
        );
    }
}
