<?php
declare(strict_types=1);

namespace Landingi\Core\Client\Landingi;

interface LandingPageTemplatesClient
{
    public function getIndustries(): array;
    public function getTags(): array;
    public function getAll(): array;
    public function get(string $identifier): array;
}
