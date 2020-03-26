<?php
declare(strict_types=1);

namespace Landingi\Shared\Domain;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testCanBeCreatedWithValidEmail() : void
    {
        self::assertInstanceOf(Email::class, new Email('user@example.com'));
    }

    public function testCastToString() : void
    {
        self::assertSame('user@example.com', (string) new Email('user@example.com'));
    }

    /**
     * @expectedException \Landingi\Shared\Domain\Exception\InvalidEmailAddress
     * @expectedExceptionMessage Given address: 'invalid' is invalid
     */
    public function testItThrowExceptionForInvalidEmail() : void
    {
        new Email('invalid');
    }

    /**
     * @expectedException \Landingi\Shared\Domain\Exception\InvalidEmailAddress
     * @expectedExceptionMessage Email mailbox (first part) cannot be number. Given address: '123456@example.com'
     */
    public function testItThrowExceptionForEmailNameAsNumber() : void
    {
        new Email('123456@example.com');
    }

    public function testGettingHost() : void
    {
        self::assertSame('example.com', (new Email('user@example.com'))->getHost());
    }

    public function testWhitespaces() : void
    {
        $email = 'test@landingi.com';
        $this->assertSame($email, (string) new Email(" $email "));
        $this->assertSame($email, (string) new Email("\t\t$email"));
        $this->assertSame($email, (string) new Email("$email\n\n"));
    }
}
