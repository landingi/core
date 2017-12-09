<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Query;

use PHPUnit\Framework\TestCase;

class QueryLimitTest extends TestCase
{
    public function testLimitCannotBeNegative()
    {
        self::assertEquals(new QueryLimit(0), new QueryLimit(-1));
    }

    public function testCastToString()
    {
        self::assertSame('1', (string) new QueryLimit(1));
    }

    public function testCastToNumber()
    {
        self::assertSame(2, (new QueryLimit(2))->toNumber());
    }
}
