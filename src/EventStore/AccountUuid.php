<?php
declare(strict_types=1);

namespace Landingi\Core\EventStore;

use Symfony\Component\Uid\Uuid;

final class AccountUuid implements \JsonSerializable
{
    private $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid->jsonSerialize();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function jsonSerialize(): string
    {
        return $this->uuid->jsonSerialize();
    }
}
