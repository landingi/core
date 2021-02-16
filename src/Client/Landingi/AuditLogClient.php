<?php
declare(strict_types=1);

namespace Landingi\Core\Client\Landingi;

interface AuditLogClient
{
    public function addEvent(array $event): void;
}
