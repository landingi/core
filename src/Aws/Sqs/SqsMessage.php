<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\Sqs;

use Landingi\Core\Queue\Message;

final class SqsMessage implements Message
{
    private $body;

    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function jsonSerialize(): array
    {
        return $this->body;
    }
}
