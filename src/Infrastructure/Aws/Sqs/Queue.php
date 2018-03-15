<?php
declare(strict_types=1);
namespace Landingi\Shared\Infrastructure\Aws\Sqs;

use Landingi\Shared\Infrastructure\RetryOperation;

class Queue
{
    private $sqs;
    private $arn;

    public static function forName(SqsClient $sqsClient, string $name) : Queue
    {
        return new self($sqsClient, new QueueArn($sqsClient, $name));
    }

    public function __construct(SqsClient $sqs, QueueArn $arn)
    {
        $this->sqs = $sqs;
        $this->arn = $arn;
    }

    /**
     * @return array|\Landingi\Shared\Infrastructure\Aws\Sqs\Message[]
     */
    public function list() : array
    {
        return array_map(
            function ($message) {
                return new Message(
                    json_decode($message['Body'], true),
                    $message['ReceiptHandle'],
                    $message['Attributes']['ApproximateReceiveCount'] ?? 1
                );
            },
            $this->sqs->receiveMessage([
                'AttributeNames' => ['ApproximateReceiveCount'],
                'QueueUrl' => (string) $this->arn,
                'MaxNumberOfMessages' => 10,
            ])->search('Messages[]') ?: []
        );
    }

    public function remove($handle) : void
    {
        (new RetryOperation(function () use ($handle) {
            $this->sqs->deleteMessage([
                'QueueUrl' => (string) $this->arn,
                'ReceiptHandle' => $handle,
            ]);
        }))->execute();
    }
}
