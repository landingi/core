<?php
namespace Landingi\Fake;

class Clock implements \Landingi\Shared\Infrastructure\Clock
{
    private $time;

    public function __construct($time = 0)
    {
        $this->time = $time;
    }

    public function time(): int
    {
        return $this->time;
    }

    public function increment($seconds = 1) : void
    {
        $this->time += $seconds;
    }
}
