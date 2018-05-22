<?php
namespace Landingi\Shared\Infrastructure\Queue;

use Landingi\Fake\SqsTransport;
use Landingi\Shared\Infrastructure\Queue\Extension\LimitTimeExtension;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
    public function testStopsByTimeLimitOnEmptyQueue()
    {
        $process = new Process(
            SqsTransport::withNoMessages(),
            [new LimitTimeExtension(1)]
        );
        $start = time();

        $process->process(function () {});

        $this->assertEquals(1, time() - $start);
    }

    public function testStopsByTimeLimitOnLongConsumer()
    {
        $transport = SqsTransport::withEmptyMessages(5);
        $process = new Process($transport, [new LimitTimeExtension(2)]);
        $start = time();

        $process->process(function () {
            sleep(1);
        });

        $this->assertEquals(3, count($transport->getMessages()));
        $this->assertEquals(2, time() - $start);
    }
}
