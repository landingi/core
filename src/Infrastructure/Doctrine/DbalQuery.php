<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;

abstract class DbalQuery extends QueryBuilder
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->prepareQuery();
    }

    abstract protected function prepareQuery();

    /**
     * @return \Doctrine\DBAL\Driver\Statement
     * @throws \Doctrine\DBAL\DBALException
     */
    public function executeQuery() : Statement
    {
        return $this->getConnection()->executeQuery($this);
    }
}
