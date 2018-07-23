<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Media\Hal;

use Landingi\Shared\Infrastructure\UI\Paginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Media\MediaPaginator;
use Landingi\Shared\Infrastructure\UrlQuery;
use Psr\Http\Message\UriInterface;

class HalPaginator extends MediaPaginator implements \JsonSerializable
{
    private $uri;

    public function __construct(Paginator $paginator, UriInterface $uri)
    {
        parent::__construct($paginator);
        $this->uri = $uri;
    }

    public function jsonSerialize() : array
    {
        $links = [
            'self' => (string) $this->uri,
            'prev' => (string) $this->prevUrl(),
        ];

        if (!$this->onLastPage()) {
            $links['next'] = (string) $this->nextUrl();
        }

        return $links;
    }

    private function prevUrl() : UriInterface
    {
        return $this->uri->withQuery($this->buildQueryWithPage($this->getPrevPage()));
    }

    private function nextUrl() : UriInterface
    {
        return $this->uri->withQuery($this->buildQueryWithPage($this->getNextPage()));
    }

    private function buildQueryWithPage(Paginator\Page $page) : string
    {
        return (string) $this->getUriQuery()->with('page', (string) $page);
    }

    private function getUriQuery() : UrlQuery
    {
        return UrlQuery::fromString($this->uri->getQuery());
    }
}
