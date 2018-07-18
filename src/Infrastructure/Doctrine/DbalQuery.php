<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\ResultStatement;
use Doctrine\DBAL\Query\QueryBuilder;

abstract class DbalQuery extends QueryBuilder
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->prepareQuery();
    }

    abstract protected function prepareQuery();

    public function executeQuery() : ResultStatement
    {
        return $this->getConnection()->executeQuery(
            $this->getSQL(),
            $this->getParameters(),
            $this->getParameterTypes()
        );
    }
}
