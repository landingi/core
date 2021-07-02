<?php
namespace Landingi\Shared\Infrastructure\Timer;

use PHPUnit\Framework\TestCase;

class DurationTest extends TestCase
{
    public $durationNanoseconds;
    public $durationMicroseconds;

    public function setup(): void
    {
        $this->durationNanoseconds = Duration::fromNanoseconds(12345678901234);
        $this->durationMicroseconds = Duration::fromMicroseconds(12345678901.234);
    }

    public function testAsNanoseconds(): void
    {
        $this->assertEquals(12345678901234, $this->durationNanoseconds->asNanoseconds());
        $this->assertEquals(12345678901234, $this->durationMicroseconds->asNanoseconds());
    }

    public function testAsMicroseconds(): void
    {
        $this->assertEquals(12345678901.234, $this->durationNanoseconds->asMicroseconds());
        $this->assertEquals(12345678901.234, $this->durationMicroseconds->asMicroseconds());
    }

    public function testAsMilliseconds(): void
    {
        $this->assertEquals(12345678.901234, $this->durationNanoseconds->asMilliseconds());
        $this->assertEquals(12345678.901234, $this->durationMicroseconds->asMilliseconds());
    }

    public function testAsSeconds(): void
    {
        $this->assertEquals(12345.678901234, $this->durationNanoseconds->asSeconds());
        $this->assertEquals(12345.678901234, $this->durationMicroseconds->asSeconds());
    }

    public function testAsString(): void
    {
        $this->assertEquals('03:25:45.678', $this->durationNanoseconds->asString());
        $this->assertEquals('03:25:45.678', $this->durationMicroseconds->asString());
    }
}
