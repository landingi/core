<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Query;

use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use PHPUnit\Framework\TestCase;

class QueryOffsetTest extends TestCase
{
    public function testOffsetForFirstPageAndLimit10()
    {
       $offset = new QueryOffset(Page::firstPage(), new QueryLimit(10));
       self::assertSame(0, $offset->toNumber());
    }

    public function testOffsetForSecondPageAndLimit10()
    {
        $offset = new QueryOffset(new Page(2), new QueryLimit(10));
        self::assertSame(10, $offset->toNumber());
    }

    public function testOffsetForThirdPageAndLimit10()
    {
        $offset = new QueryOffset(new Page(3), new QueryLimit(10));
        self::assertSame(20, $offset->toNumber());
    }

    public function testOffsetForThirdPageAndLimit12()
    {
        $offset = new QueryOffset(new Page(3), new QueryLimit(12));
        self::assertSame(24, $offset->toNumber());
    }
}
