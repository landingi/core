<?php
declare(strict_types=1);

namespace Landingi\Core;

final class Language
{
    private $name;

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
