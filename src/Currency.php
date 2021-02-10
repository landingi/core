<?php
declare(strict_types=1);

namespace Landingi\Core;

use function array_key_exists;
use function in_array;
use InvalidArgumentException;

final class Currency
{
    private const COUNTRIES_WITH_EURO_CURRENCY = [
        'AT' => 'AUSTRIA',
        'BE' => 'BELGIUM',
        'CY' => 'CYPRUS',
        'EE' => 'ESTONIA',
        'FI' => 'FINLAND',
        'FR' => 'FRANCE',
        'DE' => 'GERMANY',
        'GR' => 'GREECE',
        'IE' => 'IRELAND',
        'IT' => 'ITALY',
        'LV' => 'LATVIA',
        'LT' => 'LITHUANIA',
        'LU' => 'LUXEMBOURG',
        'MT' => 'MALTA',
        'NL' => 'NETHERLANDS',
        'PT' => 'PORTUGAL',
        'SK' => 'SLOVAKIA',
        'SI' => 'SLOVENIA',
        'ES' => 'SPAIN',
    ];

    private const COUNTRIES_WITH_GBP_CURRENCY = ['GB', 'GI', 'GG', 'IM', 'SH', 'GS'];
    private const USD = 'USD';
    private const PLN = 'PLN';
    private const GBP = 'GBP';
    private const RUB = 'RUB';
    private const EUR = 'EUR';
    private const BRL = 'BRL';

    private const CURRENCIES_WITH_LEFT_SIDE_SYMBOL = [self::GBP, self::USD, self::BRL];

    private string $code;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $code)
    {
        if (! in_array($code, [self::USD, self::PLN, self::RUB, self::EUR, self::GBP, self::BRL], true)) {
            throw new InvalidArgumentException('Not valid currency: '.$code);
        }

        $this->code = $code;
    }

    public function __toString(): string
    {
        return $this->code;
    }

    public static function forCountryName(string $countryName): self
    {
        $countryName = strtoupper($countryName);

        if ('POLAND' === $countryName) {
            return new self(self::PLN);
        }

        if (in_array($countryName, self::COUNTRIES_WITH_EURO_CURRENCY, true)) {
            return new self(self::EUR);
        }

        return new self(self::USD);
    }

    public static function forCountryCode(string $countryCode): self
    {
        $countryCode = strtoupper($countryCode);

        if ('PL' === $countryCode) {
            return new self(self::PLN);
        }

        if (in_array($countryCode, self::COUNTRIES_WITH_GBP_CURRENCY)) {
            return new self(self::GBP);
        }

        if (array_key_exists($countryCode, self::COUNTRIES_WITH_EURO_CURRENCY)) {
            return new self(self::EUR);
        }

        if ('BR' === $countryCode) {
            return new self(self::BRL);
        }

        return new self(self::USD);
    }

    public function equals(self $currency): bool
    {
        return $currency->code === $this->code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getSymbol(): string
    {
        switch ($this->code) {
            case self::USD:
                return '$';
            case self::EUR:
                return '€';
            case self::GBP:
                return '£';
            case self::PLN:
                return 'zł';
            case self::RUB:
                return 'RUB';
            case self::BRL:
                return 'R$';
        }

        return '';
    }

    public function hasSymbolOnTheLeftSide(): bool
    {
        return in_array($this->code, self::CURRENCIES_WITH_LEFT_SIDE_SYMBOL);
    }
}
