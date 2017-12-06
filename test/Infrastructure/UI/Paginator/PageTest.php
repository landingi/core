<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testCastingToString()
    {
        self::assertEquals('1', (string) new Page(1));
    }

    public function testEqualsAsValueObject()
    {
        self::assertTrue((new Page(1))->equals(new Page(1)));
        self::assertFalse((new Page(1))->equals(new Page(2)));
    }

    public function testFirstPageNamedConstructor()
    {
        self::assertEquals(Page::firstPage(), new Page(1));
    }

    public function testToNumber()
    {
        self::assertSame(1, Page::firstPage()->toNumber());
    }

    public function testIsFirstPage()
    {
        self::assertTrue(Page::firstPage()->isFirstPage());
        self::assertFalse((new Page(2))->isFirstPage());
    }

    public function testPrevPage()
    {
        self::assertEquals((new Page(2))->prevPage(), new Page(1));
        self::assertEquals((new Page(3))->prevPage(), new Page(2));
        self::assertEquals((new Page(13))->prevPage(), new Page(12));
    }

    public function testPrevPageFromFirstPage()
    {
        self::assertEquals(Page::firstPage()->prevPage(), Page::firstPage());
    }

    public function testNextPage()
    {
        self::assertEquals((new Page(2))->nextPage(), new Page(3));
        self::assertEquals((new Page(3))->nextPage(), new Page(4));
        self::assertEquals((new Page(13))->nextPage(), new Page(14));
    }
}
