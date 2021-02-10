<?php
declare(strict_types=1);

namespace Landingi\Core\Client\Landingi;

use JsonSerializable;

interface ChangeLogClient
{
    public function getAll(): array;
    public function get(string $uuid): array;
    public function create(JsonSerializable $data): void;
    public function update(JsonSerializable $data): void;
    public function remove(string $identifier): void;
}
