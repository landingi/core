<?php
declare(strict_types=1);

namespace Landingi\Core\Queue;

interface Message
{
    public function getBody(): array;
    public function jsonSerialize(): array;
}
