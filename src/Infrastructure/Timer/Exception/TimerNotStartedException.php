<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Timer\Exception;

use \Exception;
use \Throwable;

final class TimerNotStartedException extends Exception
{
    public function __construct(string $name, Throwable $previous = null)
    {
        parent::__construct("Timer '$name' was not started.", 0, $previous);
    }
}
