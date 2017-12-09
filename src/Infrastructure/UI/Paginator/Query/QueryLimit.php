<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Query;

class QueryLimit
{
    private $number;

    public function __construct(int $number)
    {
        $this->number = max(0, $number);
    }

    public function __toString()
    {
        return (string) $this->number;
    }

    public function toNumber() : int
    {
        return $this->number;
    }
}
