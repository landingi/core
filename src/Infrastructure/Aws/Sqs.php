<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Aws;

use Aws\Sqs\Exception\SqsException;
use Aws\Sqs\SqsClient;
use Landingi\Shared\Infrastructure\Aws\Sqs\Message;
use Landingi\Shared\Infrastructure\Aws\Sqs\SqsClient as SqsRegionClient;

class Sqs
{
    private $queuePrefix;
    private $sqs;

    public static function landingiFrankfurt(array $options = []) : Sqs
    {
        return new self(new SqsRegionClient('eu-central-1', $options));
    }

    public static function landingiIreland(array $options = []) : Sqs
    {
        return new self(new SqsRegionClient('eu-west-1', $options));
    }

    public function __construct(SqsClient $client)
    {
        $this->sqs = $client;
        $this->queuePrefix = sprintf('https://sqs.%s.amazonaws.com/084824767965', $client->getRegion());

        if (false === strpos($this->queuePrefix, (string) $client->getEndpoint())) {
            $this->queuePrefix = (string) $client->getEndpoint();
        }
    }

    public function handle($queueUrl, \Closure $closure) : void
    {
        if (0 !== strpos($queueUrl, 'https://')) {
            $queueUrl = $this->getQueueUrl($queueUrl);
        }

        foreach ($this->getMessages($queueUrl) as $message) {
            try {
                $closure($message);
                $this->removeMessage($queueUrl, $message);
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 999:
                        $this->removeMessage($queueUrl, $message);
                        break;
                    case 998:
                        return;
                    default:
                        throw $e;
                }
            }
        }
    }

    public function sendMessage(Message $message, $queueUrl) : void
    {
        if (0 !== strpos($queueUrl, 'https://')) {
            $queueUrl = $this->getQueueUrl($queueUrl);
        }

        $this->sqs->sendMessage([
            'QueueUrl'    => $queueUrl,
            'MessageBody' => json_encode($message)
        ]);
    }

    public function getQueueUrl($name) : string
    {
        return $this->queuePrefix.'/'.$name;
    }

    private function getMessages($queueUrl) : array
    {
        $messages = [];
        $result = $this->sqs->receiveMessage([
            'MaxNumberOfMessages' => 10,
            'QueueUrl' => $queueUrl,
        ])->search('Messages[]');

        foreach ($result as $message) {
            $messages[] = new Message(json_decode($message['Body'], true), $message['ReceiptHandle']);
        }

        return $messages;
    }

    private function removeMessage($queueUrl, Message $message, $retry = 0) : void
    {
        try {
            $this->sqs->deleteMessage(
                [
                    'QueueUrl' => $queueUrl,
                    'ReceiptHandle' => $message->getHandle(),
                ]
            );
        } catch (SqsException $e) {
            if ($retry > 5) {
                throw $e;
            }

            $this->removeMessage($queueUrl, $message, $retry + 1);
        }
    }
}
