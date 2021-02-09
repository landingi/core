<?php
declare(strict_types=1);

namespace Landingi\Core;

use function in_array;

final class Language
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function isAvailable(): bool
    {
        return in_array($this->name, ['en', 'pl']);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
