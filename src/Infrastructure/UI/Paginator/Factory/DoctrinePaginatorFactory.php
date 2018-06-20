<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Factory;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM\QueryFactory;
use Landingi\Shared\Infrastructure\UI\Paginator\DoctrinePaginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;

class DoctrinePaginatorFactory
{
    private $factory;

    public function __construct(QueryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function build(Query $query, Page $page, QueryLimit $limit) : DoctrinePaginator
    {
        return new DoctrinePaginator(
            new Paginator(
                $this->factory->build($query, $page, $limit),
                false
            ),
            $page
        );
    }
}
