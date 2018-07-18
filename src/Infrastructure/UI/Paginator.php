<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI;

use Landingi\Shared\Infrastructure\UI\Paginator\Page;

interface Paginator
{
    public function getItems() : array;
    public function count() : int;
    public function getPage() : Paginator\Page;
    public function getLimit() : int;
    public function getFirstPage() : Page;
    public function getLastPage() : Page;
    public function onFirstPage() : bool;
    public function onLastPage() : bool;
}
