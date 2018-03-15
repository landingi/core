<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure;

class RetryOperation
{
    /**
     * @var \Closure
     */
    private $closure;

    /**
     * @var int
     */
    private $maxRetries;

    public function __construct(\Closure $closure, int $maxRetries = 5)
    {
        if ($maxRetries <= 0) {
            throw new \OutOfBoundsException('max attempts must be greater than 0');
        }

        $this->closure = $closure;
        $this->maxRetries = $maxRetries;
    }

    public function execute() : void
    {
        $leftRetries = $this->maxRetries;

        while ($leftRetries--) {
            try {
                call_user_func($this->closure);
            } catch (\Throwable $e) {
                if (0 === $leftRetries) {
                    throw $e;
                }
            }
        }
    }
}
