<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Timer;

use Landingi\Shared\Infrastructure\Timer\Exception\TimerNotStartedException;

use function hrtime;

final class Timer
{
    private $timers = [];

    public function start(string $name): void
    {
        $this->timers[$name] = (float) hrtime(true);
    }

    public function isExists(string $name): bool
    {
        return isset($this->timers[$name]);
    }

    /**
     * @throws TimerNotStartedException
     */
    public function getStartTime(string $name): float
    {
        if (!$this->isExists($name)) {
            throw new TimerNotStartedException($name);
        }

        return $this->timers[$name];
    }

    /**
     * @throws TimerNotStartedException
     */
    public function getDuration(string $name): Duration
    {
        return Duration::fromNanoseconds((float) hrtime(true) - $this->getStartTime($name));
    }
}
