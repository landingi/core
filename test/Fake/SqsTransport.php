<?php
namespace Landingi\Fake;

use Landingi\Shared\Infrastructure\Queue\Message;

class SqsTransport implements \Landingi\Shared\Infrastructure\Queue\Transport
{
    private $messages;

    public static function withNoMessages() : self
    {
        return new self();
    }

    public static function withEmptyMessages(int $amount) : self
    {
        $messages = [];

        for ($i = 0; $i < $amount; $i++) {
            $messages[] = new \Landingi\Shared\Infrastructure\Aws\Sqs\Message([]);
        }

        return new self($messages);
    }

    private function __construct($messages = [])
    {
        $this->messages = $messages;
    }

    public function remove(Message $message): void
    {
        $this->messages = array_filter($this->messages, function (Message $existing) use ($message) {
            return $existing !== $message;
        });
    }

    public function retry(Message $message): void
    {

    }

    /** @return array|Message[] */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
