<?php
declare(strict_types=1);

namespace Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

abstract class DbalQuery extends QueryBuilder
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->prepareQuery();
    }

    abstract protected function prepareQuery();
}
