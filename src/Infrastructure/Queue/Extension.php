<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue;

interface Extension
{
    public function onProcessStart() : void;
    public function onExceptionThrown(\Throwable $exception, Message $message) : void;
}
