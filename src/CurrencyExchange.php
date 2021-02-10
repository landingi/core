<?php
declare(strict_types=1);

namespace Landingi\Core;

interface CurrencyExchange
{
    public function exchange(Currency $from, Currency $to): float;
}
