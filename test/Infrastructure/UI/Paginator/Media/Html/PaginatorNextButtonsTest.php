<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator\InMemoryPaginator;
use PHPUnit\Framework\TestCase;

class PaginatorNextButtonsTest extends TestCase
{
    public function testNoPreviousButtonsOnLastPage()
    {
        $buttons = new PaginatorNextButtons(
            new HtmlPaginator(
                new InMemoryPaginator(['one','two','three'], $page = 2, $limit = 2)
            )
        );

        self::assertSame('', (string) $buttons);
    }

    public function testDisplayPreviousButtonsOnSecondPage()
    {
        $buttons = new PaginatorNextButtons(
            new HtmlPaginator(
                new InMemoryPaginator(['one', 'two', 'three', 'four', 'five'], $page = 2, $limit = 2)
            )
        );

        self::assertXmlStringEqualsXmlString(
            "<div>$buttons</div>",
            <<<EXPECTED
<div>
    <li class="next"><a href="?page=3"><i class="fa fa-chevron-right"/></a></li>
    <li class="last"><a href="?page=3"><i class="fa fa-chevron-right"/><i class="fa fa-chevron-right"/></a></li>
</div>
EXPECTED
        );
    }

    public function testDisplayPreviousButtonsOnFirstPage()
    {
        $buttons = new PaginatorNextButtons(
            new HtmlPaginator(
                new InMemoryPaginator(['one', 'two', 'three', 'four', 'five'], $page = 1, $limit = 2)
            )
        );

        self::assertXmlStringEqualsXmlString(
            "<div>$buttons</div>",
            <<<EXPECTED
<div>
    <li class="next"><a href="?page=2"><i class="fa fa-chevron-right"/></a></li>
    <li class="last"><a href="?page=3"><i class="fa fa-chevron-right"/><i class="fa fa-chevron-right"/></a></li>
</div>
EXPECTED
        );
    }
}
