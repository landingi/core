<?php
declare(strict_types=1);

namespace Landingi\Core;

use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    public function testIsAvailable(): void
    {
        self::assertTrue((new Language('en'))->isAvailable());
        self::assertTrue((new Language('pl'))->isAvailable());
    }
}
