<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI;

interface Paginator
{
    public function getItems() : array;
    public function count() : int;
    public function getPage() : Paginator\Page;
    public function getLimit() : int;
    public function onLastPage() : bool;
    public function getLastPage() : int;
}
