<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue;

interface Extension
{
    public function onProcessIterationStart() : void;
    public function onProcessIterationExceptionThrown(\Throwable $exception) : void;
    public function onMessageProcessingStart() : void;
    public function onMessageProcessingExceptionThrown(\Throwable $exception, Message $message) : void;
}
