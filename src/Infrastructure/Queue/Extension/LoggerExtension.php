<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue\Extension;

use Landingi\Shared\Infrastructure\Queue\Message;
use Monolog\Logger;

class LoggerExtension extends EmptyExtension
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onExceptionThrown(\Throwable $exception, Message $message) : void
    {
        $this->logger->error($exception->getMessage(), [
            'exception' => $exception,
            'exception-code' => $exception->getCode(),
            'message' => $message->getBody(),
        ]);
    }
}
