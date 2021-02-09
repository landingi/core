<?php
declare(strict_types=1);

namespace Landingi\Core;

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testItGetsCodeForCountryName(): void
    {
        self::assertEquals('PLN', Currency::forCountryName('poland')->getCode());
        self::assertEquals('USD', Currency::forCountryName('england')->getCode());
        self::assertEquals('EUR', Currency::forCountryName('germany')->getCode());
    }

    public function testItHasEuroCurrency(): void
    {
        self::assertEquals('EUR', Currency::forCountryCode('at')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('be')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('cy')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('ee')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('fi')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('fr')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('de')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('gr')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('ie')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('it')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('lv')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('lt')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('lu')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('mt')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('nl')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('pt')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('sk')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('si')->getCode());
        self::assertEquals('EUR', Currency::forCountryCode('es')->getCode());
    }

    public function testItHasGBPCurrency(): void
    {
        self::assertEquals('GBP', Currency::forCountryCode('gb')->getCode());
        self::assertEquals('GBP', Currency::forCountryCode('gi')->getCode());
        self::assertEquals('GBP', Currency::forCountryCode('gg')->getCode());
        self::assertEquals('GBP', Currency::forCountryCode('im')->getCode());
        self::assertEquals('GBP', Currency::forCountryCode('sh')->getCode());
        self::assertEquals('GBP', Currency::forCountryCode('gs')->getCode());
    }

    public function testAcceptedCodes(): void
    {
        self::assertEquals('PLN', (new Currency('PLN'))->getCode());
        self::assertEquals('USD', (new Currency('USD'))->getCode());
        self::assertEquals('RUB', (new Currency('RUB'))->getCode());
        self::assertEquals('EUR', (new Currency('EUR'))->getCode());
        self::assertEquals('GBP', (new Currency('GBP'))->getCode());
        self::assertEquals('BRL', (new Currency('BRL'))->getCode());
    }

    public function testEqualsMethod(): void
    {
        self::assertTrue(Currency::forCountryCode('pl')->equals(new Currency('PLN')));
        self::assertTrue(Currency::forCountryCode('en')->equals(new Currency('USD')));
        self::assertTrue(Currency::forCountryCode('de')->equals(new Currency('EUR')));
        self::assertTrue(Currency::forCountryCode('gb')->equals(new Currency('GBP')));
        self::assertTrue(Currency::forCountryCode('br')->equals(new Currency('BRL')));
    }

    public function testSymbolSide(): void
    {
        self::assertTrue((new Currency('GBP'))->hasSymbolOnTheLeftSide());
        self::assertTrue((new Currency('USD'))->hasSymbolOnTheLeftSide());
        self::assertTrue((new Currency('BRL'))->hasSymbolOnTheLeftSide());
        self::assertFalse((new Currency('PLN'))->hasSymbolOnTheLeftSide());
        self::assertFalse((new Currency('EUR'))->hasSymbolOnTheLeftSide());
        self::assertFalse((new Currency('RUB'))->hasSymbolOnTheLeftSide());
    }
}
