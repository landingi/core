<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue\Transport;

use Landingi\Shared\Infrastructure\Aws\Sqs\Queue as SqsQueue;
use Landingi\Shared\Infrastructure\Queue\Message;
use Landingi\Shared\Infrastructure\Queue\Transport;

class SqsTransport implements Transport
{
    private $queue;

    public function __construct(SqsQueue $queue)
    {
        $this->queue = $queue;
    }

    public function getMessages() : array
    {
        return $this->queue->list();
    }

    public function remove(Message $message) : void
    {
        $this->queue->remove($message->getHandle());
    }

    public function retry(Message $message) : void
    {
       // do nothing SQS automatically retry processing message after 60 seconds
    }
}
