<?php
declare(strict_types=1);

namespace Landingi\Core\Client\Landingi;

interface PopupTemplatesClient
{
    public function getAll(): array;

    public function get(string $identifier): array;

    public function delete(string $identifier): array;
}
