<?php
namespace Landingi\Shared\Infrastructure\Queue;

use Landingi\Fake\Clock;
use Landingi\Fake\SqsTransport;
use Landingi\Shared\Infrastructure\Queue\Extension\LimitTimeExtension;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
    public function testStopsByTimeLimitOnEmptyQueue()
    {
        $clock = new Clock();
        $process = new Process(
            SqsTransport::withNoMessages(),
            [new LimitTimeExtension(1, $clock)]
        );
        $start = $clock->time();
        $clock->increment();

        $process->process(function () {});

        $this->assertEquals(1, $clock->time() - $start);
    }

    public function testStopsByTimeLimitOnLongConsumer()
    {
        $clock = new Clock();
        $transport = SqsTransport::withEmptyMessages(5);
        $process = new Process($transport, [new LimitTimeExtension(2, $clock)]);
        $start = $clock->time();

        $process->process(function () use ($clock) {
            $clock->increment(1);
        });

        $this->assertCount(3, $transport->getMessages());
        $this->assertEquals(2, $clock->time() - $start);
    }
}
