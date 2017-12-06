<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

class Page
{
    private $number;

    public static function firstPage() : Page
    {
        return new self(1);
    }

    public function __construct(int $number)
    {
        $this->number = max(1, $number);
    }

    public function __toString()
    {
        return (string) $this->number;
    }

    public function toNumber() : int
    {
        return $this->number;
    }

    public function equals(Page $page) : bool
    {
        return $this->number === $page->number;
    }

    public function isFirstPage() : bool
    {
        return $this->equals(self::firstPage());
    }

    public function prevPage() : Page
    {
        return new self($this->number - 1);
    }

    public function nextPage() : Page
    {
        return new self($this->number + 1);
    }
}
