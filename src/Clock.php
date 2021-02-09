<?php
declare(strict_types=1);

namespace Landingi\Core;

use DateTimeInterface;

interface Clock
{
    public function getNow(): DateTimeInterface;
}
