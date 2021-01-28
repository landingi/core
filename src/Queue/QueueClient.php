<?php
declare(strict_types=1);

namespace Landingi\Core\Queue;

interface QueueClient
{
    public function sendMessage(Message $message, MessageMetadata $metadata): void;
}
