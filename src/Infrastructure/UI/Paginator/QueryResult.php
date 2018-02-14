<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Landingi\Shared\Infrastructure\Doctrine\DbalQuery;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryOffset;

class QueryResult
{
    private $query;
    private $limit;
    private $offset;
    private $items;
    private $total;

    public function __construct(DbalQuery $query, QueryLimit $limit, QueryOffset $offset)
    {
        $this->query = $query;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getItems() : array
    {
        if (null === $this->items) {
            $this->items = $this->getLimitedQuery()->executeQuery()->fetchAll();
        }

        return $this->items;
    }

    public function getTotal() : int
    {
        if (null === $this->total) {
            $this->total = (int) $this->query->getConnection()->fetchColumn(
                sprintf('SELECT COUNT(*) FROM (%s) t', $this->query),
                $this->query->getParameters(),
                0,
                $this->query->getParameterTypes()
            );
        }

        return $this->total;
    }

    private function getLimitedQuery() : DbalQuery
    {
        $query = clone $this->query;
        $query->setMaxResults($this->limit->toNumber());
        $query->setFirstResult($this->offset->toNumber());

        return $query;
    }
}
