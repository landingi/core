<?php
declare (strict_types=1);

use Landingi\Shared\Infrastructure\Aws\Sqs\Message;

final class SqsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Landingi\Fake\SqsClient
     */
    private $client;

    /**
     * @var \Landingi\Shared\Infrastructure\Aws\Sqs
     */
    private $sqs;

    protected function setUp() : void
    {
        $this->client = Landingi\Fake\SqsClient::withMessages();
        $this->sqs = new Landingi\Shared\Infrastructure\Aws\Sqs($this->client);
    }

    public function testHandleRemovesMessageOn999Exception() : void
    {
        self::assertTrue($this->client->hasMessageWithHandle('handle-0'));

        $this->sqs->handle('queue', function () {
            throw new \RuntimeException('This exception should remove the message from the queue', 999);
        });

        self::assertFalse($this->client->hasMessageWithHandle('handle-0'));
    }

    public function testHandleLeavesMessageOn999Exception() : void
    {
        self::assertTrue($this->client->hasMessageWithHandle('handle-0'));

        $this->sqs->handle('queue', function () {
            throw new \RuntimeException('This exception should leave the message in the queue', 998);
        });

        self::assertTrue($this->client->hasMessageWithHandle('handle-0'));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage This exception should be thrown up the execution chain
     */
    public function testHandleThrowsUpTheChainOnAnyOtherException() : void
    {
        self::assertTrue($this->client->hasMessageWithHandle('handle-0'));

        $this->sqs->handle('queue', function () {
            throw new \RuntimeException('This exception should be thrown up the execution chain', random_int(1, 600));
        });

        self::assertTrue($this->client->hasMessageWithHandle('handle-0'));
    }

    public function testSendMessage() : void
    {
        self::assertFalse($this->client->hasMessageWithHandle('handle-1'));

        $this->sqs->sendMessage(new Message([]), 'queue');

        self::assertTrue($this->client->hasMessageWithHandle('handle-1'));
    }
}
