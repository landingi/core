<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue;

interface Message
{
    public function getBody() : array;
    public function get($name);
    public function getHandle() : string;
    public function isLooped() : bool;
}
