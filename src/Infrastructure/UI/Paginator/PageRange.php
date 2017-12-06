<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Landingi\Shared\Infrastructure\UI\Paginator\Media\Html\HtmlPaginator;

class PageRange
{
    private const RANGE = 10;

    private $currentPage;
    private $lastPage;

    public static function fromHtmlPaginator(HtmlPaginator $paginator): PageRange
    {
        return new self(
            $paginator->getPage()->toNumber(),
            $paginator->getLastPage()
        );
    }

    public function __construct($currentPage, $lastPage)
    {
        $this->currentPage = $currentPage;
        $this->lastPage = $lastPage;
    }

    public function getPages() : array
    {
        $current = $this->currentPage;
        $pageCount = $this->lastPage;
        $pageRange = self::RANGE;

        if ($pageRange > $pageCount) {
            $pageRange = $pageCount;
        }

        $delta = (int) ceil($pageRange / 2);

        if ($current - $delta > $pageCount - $pageRange) {
            $pages = range($pageCount - $pageRange + 1, $pageCount);
        } else {
            if ($current - $delta < 0) {
                $delta = $current;
            }

            $offset = $current - $delta;
            $pages = range($offset + 1, $offset + $pageRange);
        }

        return $pages;
    }
}
