<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Landingi\Shared\Infrastructure\UI\Paginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryOffset;

class DoctrinePaginator implements Paginator
{
    private $paginator;
    private $limit;
    private $page;

    public static function withOffset(OrmPaginator $paginator, Page $page, QueryLimit $limit)
    {
        $query = $paginator->getQuery();
        $query->setFirstResult((new QueryOffset($page, $limit))->toNumber());
        $query->setMaxResults($limit->toNumber());

        return new self($paginator, $page, $limit);
    }

    public function __construct(OrmPaginator $paginator, Page $page, QueryLimit $limit)
    {
        $this->paginator = $paginator;
        $this->page = $page;
        $this->limit = $limit;
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
        return $this->limit->toNumber();
    }
}
