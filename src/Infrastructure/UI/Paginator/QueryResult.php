<?php
declare(strict_types=1);

namespace Infrastructure\UI\Paginator;

use Landingi\Shared\Infrastructure\Doctrine\DbalQuery;

class QueryResult
{
    private $query;
    private $limit;
    private $offset;
    private $items;
    private $total;

    public function __construct(DbalQuery $query, $limit, $offset)
    {
        $this->query = $query;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        if (null === $this->items) {
            $this->items = $this->getLimitedQuery()->execute()->fetchAll();
        }

        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        if (null === $this->total) {
            $this->total = $this->query->execute()->rowCount();
        }

        return $this->total;
    }

    private function getLimitedQuery() : DbalQuery
    {
        $query = clone $this->query;
        $query->setMaxResults($this->limit);
        $query->setFirstResult($this->offset);

        return $query;
    }
}
