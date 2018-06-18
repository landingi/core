<?php
declare(strict_types=1);

namespace Landingi\Fake;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\SQLAnywhere\Driver;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

class FakeEntityManager extends EntityManager
{
    public function __construct()
    {
        $configuration = new Configuration();
        $configuration->setProxyDir('proxy/dir');
        $configuration->setProxyNamespace('Proxy\Namespace');

        parent::__construct(new Connection([], new Driver()), $configuration, new EventManager());
    }
}
