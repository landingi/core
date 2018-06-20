<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
            $this->factory->build($query, $page, $limit),
            false
        );
    }
}
