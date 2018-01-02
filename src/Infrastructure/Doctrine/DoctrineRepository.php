<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Landingi\Shared\Infrastructure\Doctrine\Exception\EntityNotExists;

abstract class DoctrineRepository extends EntityRepository
{
    /**
     * @throws \Landingi\Shared\Infrastructure\Doctrine\Exception\EntityNotExists
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $entity = parent::find($id, $lockMode, $lockVersion);

        if (!$entity) {
            throw EntityNotExists::forPrimaryKey((string) $id);
        }

        return $entity;
    }

    /**
     * @throws \Landingi\Shared\Infrastructure\Doctrine\Exception\EntityNotExists
     */
    public function findOneByQuery(Query $query)
    {
        $query->setMaxResults(1);
        $entity = $query->execute();

        if (\is_array($entity)) {
            $entity = array_shift($entity);
        }

        if (!$entity) {
            throw EntityNotExists::forQuery();
        }

        return $entity;
    }
}
