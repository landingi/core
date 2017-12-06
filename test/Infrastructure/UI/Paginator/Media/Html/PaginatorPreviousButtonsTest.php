<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator\InMemoryPaginator;
use PHPUnit\Framework\TestCase;

class PaginatorPreviousButtonsTest extends TestCase
{
    public function testNoPreviousButtonsOnFirstPage()
    {
        $buttons = new PaginatorPreviousButtons(
            new HtmlPaginator(
                new InMemoryPaginator(['one','two','three'], $page = 1, $limit = 2)
            )
        );

        self::assertSame('', (string) $buttons);
    }

    public function testDisplayPreviousButtonsOnSecondPage()
    {
        $buttons = new PaginatorPreviousButtons(
            new HtmlPaginator(
                new InMemoryPaginator(['one','two','three'], $page = 2, $limit = 2)
            )
        );

        self::assertXmlStringEqualsXmlString(
            "<div>$buttons</div>",
            <<<EXPECTED
<div>
    <li class="first"><a href="?page=1"><i class="fa fa-chevron-left"/><i class="fa fa-chevron-left"/></a></li>
    <li class="prev"><a href="?page=1"><i class="fa fa-chevron-left"/></a></li>
</div>
EXPECTED
        );
    }
}
