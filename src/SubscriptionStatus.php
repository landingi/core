<?php
declare(strict_types=1);

namespace Landingi\Core;

use InvalidArgumentException;
use function in_array;

final class SubscriptionStatus
{
    private const AVAILABLE_STATUS = [
        'PastDue',
        'Active',
        'Canceled',
        'Pending',
    ];
    private string $status;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $status)
    {
        if (! in_array($status, self::AVAILABLE_STATUS)) {
            throw new InvalidArgumentException('Invalid subscription status');
        }

        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
