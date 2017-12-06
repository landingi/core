<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use PHPUnit\Framework\TestCase;

class PageRangeTest extends TestCase
{
    public function testSinglePage()
    {
        $range = new PageRange(1,1);
        self::assertCount(1, $range->getPages());
        self::assertEquals(1, $range->getPages()[0]);
    }

    public function testOnFirstPageWithTwoPages()
    {
        $range = new PageRange(1,2);
        self::assertCount(2, $range->getPages());
        self::assertEquals(1, $range->getPages()[0]);
        self::assertEquals(2, $range->getPages()[1]);
    }

    public function testOnSecondPageWithTwoPages()
    {
        $range = new PageRange(2,2);
        self::assertCount(2, $range->getPages());
        self::assertEquals(1, $range->getPages()[0]);
        self::assertEquals(2, $range->getPages()[1]);
    }

    public function testOnFirstPageWithTenPages()
    {
        $range = new PageRange(1,10);
        self::assertCount(10, $range->getPages());
        self::assertEquals(1, $range->getPages()[0]);
        self::assertEquals(10, $range->getPages()[9]);
    }

    public function testOnFirstPageWithFifteenPages()
    {
        $range = new PageRange(1,15);
        self::assertCount(10, $range->getPages());
        self::assertEquals(1, $range->getPages()[0]);
        self::assertEquals(10, $range->getPages()[9]);
    }

    public function testOnEightPageWithFifteenPages()
    {
        $range = new PageRange(8,15);
        self::assertCount(10, $range->getPages());
        self::assertEquals(4, $range->getPages()[0]);
        self::assertEquals(13, $range->getPages()[9]);
    }
}
