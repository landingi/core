<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator\InMemoryPaginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use PHPUnit\Framework\TestCase;

class HtmlPaginatorTest extends TestCase
{
    public function testGetPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator([], 1)
        );

        self::assertEquals(Page::firstPage(), $paginator->getPage());
    }

    public function testOnFirstPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator([], 1)
        );

        self::assertTrue($paginator->onFirstPage());
    }

    public function testNotFirstPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator([], 2)
        );

        self::assertFalse($paginator->onFirstPage());
    }

    public function testPrevPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator([], 2)
        );

        self::assertEquals(Page::firstPage(), $paginator->getPrevPage());
    }

    public function testNextPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator([], 2)
        );

        self::assertEquals(new Page(3), $paginator->getNextPage());
    }

    public function testLastPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator(['one', 'two', 'three'], $page = 1, $limit = 2)
        );

        self::assertEquals(2, $paginator->getLastPage());
    }

    public function testOnLastPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator(['one', 'two', 'three'], $page = 2, $limit = 2)
        );

        self::assertTrue($paginator->onLastPage());
    }

    public function testNoRenderForOnlyOnePage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator(['one'], $page = 1, $limit = 2)
        );

        self::assertEquals('', (string) $paginator);
    }

    public function testRenderOnFirstPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator(['one', 'two', 'three', 'four', 'five'], $page = 1, $limit = 2)
        );

        self::assertXmlStringEqualsXmlString(
            (string) $paginator, <<<EXPECTED
<div class="pagination-wrap">
    <ul class="pagination">
        <li class="active"><a href="?page=1">1</a></li>
        <li class=""><a href="?page=2">2</a></li>
        <li class=""><a href="?page=3">3</a></li>
        <li class="next"><a href="?page=2"><i class="fa fa-chevron-right"/></a></li>
        <li class="last"><a href="?page=3"><i class="fa fa-chevron-right"/><i class="fa fa-chevron-right"/></a></li>
    </ul>
</div>
EXPECTED
        );
    }

    public function testRenderOnSecondPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator(['one', 'two', 'three', 'four', 'five'], $page = 2, $limit = 2)
        );

        self::assertXmlStringEqualsXmlString(
            (string) $paginator, <<<EXPECTED
<div class="pagination-wrap">
    <ul class="pagination">
        <li class="first"><a href="?page=1"><i class="fa fa-chevron-left"/><i class="fa fa-chevron-left"/></a></li>
        <li class="prev"><a href="?page=1"><i class="fa fa-chevron-left"/></a></li>
        <li class=""><a href="?page=1">1</a></li>
        <li class="active"><a href="?page=2">2</a></li>
        <li class=""><a href="?page=3">3</a></li>
        <li class="next"><a href="?page=3"><i class="fa fa-chevron-right"/></a></li>
        <li class="last"><a href="?page=3"><i class="fa fa-chevron-right"/><i class="fa fa-chevron-right"/></a></li>
    </ul>
</div>
EXPECTED
        );
    }

    public function testRenderOnLastPage()
    {
        $paginator = new HtmlPaginator(
            new InMemoryPaginator(['one', 'two', 'three', 'four', 'five'], $page = 3, $limit = 2)
        );

        self::assertXmlStringEqualsXmlString(
            (string) $paginator, <<<EXPECTED
<div class="pagination-wrap">
    <ul class="pagination">
        <li class="first"><a href="?page=1"><i class="fa fa-chevron-left"/><i class="fa fa-chevron-left"/></a></li>
        <li class="prev"><a href="?page=2"><i class="fa fa-chevron-left"/></a></li>
        <li class=""><a href="?page=1">1</a></li>
        <li class=""><a href="?page=2">2</a></li>
        <li class="active"><a href="?page=3">3</a></li>
    </ul>
</div>
EXPECTED
        );
    }
}
