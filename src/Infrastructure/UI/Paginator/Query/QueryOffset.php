<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Query;

use Landingi\Shared\Infrastructure\UI\Paginator\Page;

class QueryOffset
{
    private $page;
    private $limit;

    public function __construct(Page $page, QueryLimit $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    public function __toString()
    {
        return (string) $this->toNumber();
    }

    public function toNumber() : int
    {
        return ($this->page->toNumber() - 1) * $this->limit->toNumber();
    }
}
