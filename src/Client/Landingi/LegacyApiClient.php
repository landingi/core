<?php
declare(strict_types=1);

namespace Landingi\Core\Client\Landingi;

interface LegacyApiClient
{
    public function getFeatures(): array;
}
