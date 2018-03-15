<?php
declare (strict_types=1);

namespace Landingi\Fake;

use Aws\Result;

class SqsClient extends \Aws\Sqs\SqsClient
{
    private $messages = [];

    public function __construct()
    {
    }

    public static function withMessages($count = 1) : SqsClient
    {
        $client = new self();

        for ($i = 0; $i < $count; $i++) {
            $client->messages[] = ['Body' => '[]', 'ReceiptHandle' => sprintf('handle-%d', $i)];
        }

        return $client;
    }

    public function getEndpoint() : string
    {
        return 'localhost';
    }

    public function sendMessage(array $args = [])
    {
        $this->messages[] = [
            'Body' => $args['MessageBody'],
            'ReceiptHandle' => sprintf('handle-%d', count($this->messages))
        ];
    }

    public function receiveMessage(array $args = []) : Result
    {
        if (count($this->messages)) {
            return new Result(['Messages' => $this->messages]);
        }

        return new Result();
    }

    public function deleteMessage(array $args = []) : Result
    {
        $handle = $args['ReceiptHandle'];

        $this->messages = array_filter(
            $this->messages,
            function ($message) use ($handle) {
                return $message['ReceiptHandle'] !== $handle;
            }
        );

        return new Result($this->messages);
    }

    public function hasMessageWithHandle($handle) : bool
    {
        return array_reduce(
            $this->messages,
            function ($carry, $current) use ($handle) {
                return $carry || ($current['ReceiptHandle'] === $handle);
            },
            false
        );
    }
}
