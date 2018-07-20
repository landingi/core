<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Hal;

use GuzzleHttp\Psr7\Uri;
use Landingi\Shared\Infrastructure\UI\Paginator\InMemoryPaginator;
use PHPUnit\Framework\TestCase;

class HalPaginatorTest extends TestCase
{
    public function testOnFirstPage()
    {
        $hal = new HalPaginator(
            new InMemoryPaginator(['item', 'item'], 1, 1),
            new Uri('https://landingi.com')
        );

        self::assertEquals(
            json_encode([
                'self' => 'https://landingi.com',
                'prev' => 'https://landingi.com?page=1',
                'next' => 'https://landingi.com?page=2'
            ]),
            json_encode($hal)
        );
    }

    public function testOnMiddlePage()
    {
        $hal = new HalPaginator(
            new InMemoryPaginator(['item', 'item', 'item'], 2, 1),
            new Uri('https://landingi.com')
        );

        self::assertEquals(
            json_encode([
                'self' => 'https://landingi.com',
                'prev' => 'https://landingi.com?page=1',
                'next' => 'https://landingi.com?page=3'
            ]),
            json_encode($hal)
        );
    }

    public function testOnLastPage()
    {
        $hal = new HalPaginator(new InMemoryPaginator(['item'], 1), new Uri('https://landingi.com'));

        self::assertJsonStringEqualsJsonString(
            json_encode([
                'self' => 'https://landingi.com',
                'prev' => 'https://landingi.com?page=1',
            ]),
            json_encode($hal)
        );
    }
}
