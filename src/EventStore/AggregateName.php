<?php
declare(strict_types=1);

namespace Landingi\Core\EventStore;

final class AggregateName implements \JsonSerializable
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): string
    {
        return $this->name;
    }
}
