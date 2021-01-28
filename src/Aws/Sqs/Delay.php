<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\Sqs;

use Landingi\Core\Queue\QueueException;

final class Delay
{
    private $delay;

    /**
     * @throws QueueException
     */
    public function __construct(int $delay)
    {
        if (0 > $delay) {
            throw new QueueException('Cannot delay a message into the past!');
        }

        if (900 < $delay) {
            throw new QueueException('Cannot delay SQS messages more than 15 minutes!');
        }

        $this->delay = $delay;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }
}
