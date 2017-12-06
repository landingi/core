<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Html;

use Landingi\Shared\Infrastructure\UI\Paginator\InMemoryPaginator;
use PHPUnit\Framework\TestCase;

class PaginatorNumberButtonsTest extends TestCase
{
    public function testTwoButtons()
    {
        $buttons = new PaginatorNumberButtons(
            new HtmlPaginator(
                new InMemoryPaginator(['one','two','three'], $page = 1, $limit = 2)
            )
        );

        self::assertXmlStringEqualsXmlString(
            "<div>$buttons</div>",
            <<<EXPECTED
<div>
    <li class="active"><a href="?page=1">1</a></li>
    <li class=""><a href="?page=2">2</a></li>
</div>
EXPECTED
        );
    }
}
