<?php
namespace Landingi\Shared\Infrastructure\Queue;

use Landingi\Fake\SqsTransport;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
    public function testStopsByTimeLimitOnEmptyQueue()
    {
        $process = new Process(SqsTransport::withNoMessages(), [], 1);
        $start = time();

        $process->process(function () {});

        $this->assertEquals(1, time() - $start);
    }

    public function testStopsByTimeLimitOnLongConsumer()
    {
        $transport = SqsTransport::withEmptyMessages(5);
        $process = new Process($transport, [], 2);
        $start = time();

        $process->process(function (Message $message) {
            sleep(1);
        });

        $this->assertEquals(3, count($transport->getMessages()));
        $this->assertEquals(2, time() - $start);
    }
}
