<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\Sqs;

use Aws\Sqs\SqsClient;
use Landingi\Core\Queue\Message;
use Landingi\Core\Queue\MessageMetadata;
use Landingi\Core\Queue\QueueClient;

final class SqsQueue implements QueueClient
{
    private $client;
    private $queue;

    public function __construct(SqsClient $client, string $queue)
    {
        $this->client = $client;
        $this->queue = $queue;
    }

    /**
     * @throws \JsonException
     */
    public function sendMessage(Message $message, MessageMetadata $metadata): void
    {
        $arguments = [
            'QueueUrl' => $this->getQueueUrl(),
            'MessageBody' => json_encode($message->getBody(), JSON_THROW_ON_ERROR),
        ];

        if ($metadata) {
            $arguments['DelaySeconds'] = $metadata->getDelay();
        }

        $this->client->sendMessage($arguments);
    }

    private function getQueueUrl(): string
    {
        $endpoint = (string) $this->client->getEndpoint();

        if (! $endpoint) {
            $endpoint = sprintf('https://sqs.%s.amazonaws.com/08482476796', $this->client->getRegion());
        }

        return "${endpoint}/{$this->queue}";
    }
}
