<?php
namespace Landingi\Shared\Infrastructure\Timer;

use Landingi\Shared\Infrastructure\Timer\Exception\TimerNotStartedException;
use PHPUnit\Framework\TestCase;

class TimerTest extends TestCase
{
    /**
     * @throws Exception\TimerNotStartedException
     */
    public function testExecutionTime(): void
    {
        $timer = new Timer();
        $timer->start('test');
        sleep(1);
        $this->assertEquals(1, floor($timer->getDuration('test')->asSeconds()));
    }

    /**
     * @throws TimerNotStartedException
     */
    public function testNonExistentTimer(): void
    {
        $timer = new Timer();
        $timer->start('test');
        $this->expectException(TimerNotStartedException::class);
        $timer->getDuration('test2');
    }

    /**
     * @throws TimerNotStartedException
     */
    public function testStartTime(): void
    {
        $timer = new Timer();
        $timer->start('test');
        $this->assertTrue(is_float($timer->getStartTime('test')));
    }
}
