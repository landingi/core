<?php
declare(strict_types=1);

namespace Landingi\Core\Queue;

interface MessageMetadata
{
    public function getDelay();
}
