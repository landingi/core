<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Doctrine\Exception;

class EntityNotExists extends \Exception
{
    public static function forPrimaryKey(string $id) : EntityNotExists
    {
        return new self("Entity for primary key ($id) do not exists");
    }

    public static function forCriteria()
    {
        return new self('Entity for given criteria do not exists');
    }

    public static function forQuery(\Throwable $e = null)
    {
        return new self('Entity for given query do not exists', 0, $e);
    }
}
