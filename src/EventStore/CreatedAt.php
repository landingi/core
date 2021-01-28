<?php
declare(strict_types=1);

namespace Landingi\Core\EventStore;

use DateTime;

final class CreatedAt implements \JsonSerializable
{
    private $createdAt;

    public function __construct(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function jsonSerialize(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function __toString(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
