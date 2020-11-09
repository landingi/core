<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\InfluxDb;

final class NullInfluxDbClient implements InfluxDbClient
{
    public function write(string $measurement, array $tags = [], array $fields = [], $db = 'application'): void
    {
    }
}
