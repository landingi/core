<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Hal;

use PHPUnit\Framework\TestCase;

class UrlQueryTest extends TestCase
{
    public function testFromEmptyString()
    {
        self::assertEquals(new UrlQuery([]), UrlQuery::fromString(''));
    }

    public function testFromString()
    {
        self::assertEquals(new UrlQuery(['page' => 3]), UrlQuery::fromString('page=3'));
    }

    public function testFromStringWithTwoParts()
    {
        self::assertEquals(
            new UrlQuery([
                'page' => 3,
                'limit' => 4,
            ]),
            UrlQuery::fromString('page=3&limit=4')
        );
    }

    public function testToStringWithOnePart()
    {
        self::assertSame('page=3', (string) new UrlQuery(['page' => 3]));
    }

    public function testToStringWithTwoParts()
    {
        self::assertSame(
            'foo=bar&page=10',
            (string) new UrlQuery([
                'foo' => 'bar',
                'page' => 10,
            ])
        );
    }

    public function testToStringWithoutAnyParts()
    {
        self::assertSame('', (string) new UrlQuery([]));
    }

    public function testWithNewPart()
    {
        self::assertEquals(
            new UrlQuery(['foo' => 'bar', 'page' => '2']),
            (new UrlQuery(['foo' =>'bar']))->with('page', '2')
        );
    }

    public function testWithExistingPart()
    {
        self::assertEquals(
            new UrlQuery([
                'foo' => '3',
                'bar' => '10',
            ]),
            (new UrlQuery([
                'foo' => '2',
                'bar' => '10',
            ]))->with('foo', '3')
        );
    }
}
