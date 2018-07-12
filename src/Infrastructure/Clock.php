<?php
namespace Landingi\Shared\Infrastructure;

interface Clock
{
    public function time() : int;
}
