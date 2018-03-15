<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue\Extension;

use Landingi\Shared\Infrastructure\Queue\Extension;
use Landingi\Shared\Infrastructure\Queue\Message;

class EmptyExtension implements Extension
{
    public function onProcessStart() : void
    {
    }

    public function onExceptionThrown(\Throwable $exception, Message $message) : void
    {
    }
}
