<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue\Extension;

use Landingi\Shared\Infrastructure\Queue\Exception\LimitReached;

class LimitTimeExtension extends EmptyExtension
{
    private $secondsLimit;
    private $deadline;

    public function __construct(int $secondsLimit)
    {
        if ($secondsLimit < 1) {
            throw new \InvalidArgumentException('Cannot set time limit to the past');
        }

        $this->secondsLimit = $secondsLimit;
        $this->deadline = time() + $secondsLimit;
    }

    /**
     * @throws LimitReached
     */
    public function onProcessIterationStart() : void
    {
        $this->throwIfDeadlineReached();
    }

    /**
     * @throws LimitReached
     */
    public function onMessageProcessingStart() : void
    {
        $this->throwIfDeadlineReached();
    }

    /**
     * @throws LimitReached
     */
    private function throwIfDeadlineReached()
    {
        if (time() >= $this->deadline) {
            throw new LimitReached("Time limit reached: {$this->deadline}");
        }
    }
}
