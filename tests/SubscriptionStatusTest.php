<?php
declare(strict_types=1);

namespace Landingi\Core;

use Exception;
use PHPUnit\Framework\TestCase;

final class SubscriptionStatusTest extends TestCase
{
    public function testItIsProperStatus(): void
    {
        self::assertEquals('PastDue', new SubscriptionStatus('PastDue'));
        self::assertEquals('Active', new SubscriptionStatus('Active'));
        self::assertEquals('Canceled', new SubscriptionStatus('Canceled'));
        self::assertEquals('Pending', new SubscriptionStatus('Pending'));
    }

    public function testItIsInvalidStatus(): void
    {
        $this->expectException(Exception::class);
        new SubscriptionStatus('InvalidStatus');
    }
}
