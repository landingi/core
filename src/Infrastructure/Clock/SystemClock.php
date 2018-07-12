<?php
namespace Landingi\Shared\Infrastructure\Clock;

use Landingi\Shared\Infrastructure\Clock;

class SystemClock implements Clock
{
    public function time(): int
    {
        return time();
    }
}
