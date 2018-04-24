<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue\Extension;

use Landingi\Shared\Infrastructure\Queue\Exception\LimitReached;

class LimitMessageExtension extends EmptyExtension
{
    private $messageLimit;
    private $messageProcessed;

    public function __construct(int $messageLimit)
    {
        $this->messageLimit = $messageLimit;
        $this->messageProcessed = 0;
    }

    public function onProcessStart() : void
    {
        if ($this->messageProcessed >= $this->messageLimit) {
            throw new LimitReached("Message limit reached: {$this->messageLimit}");
        }

        $this->messageProcessed++;
    }
}
