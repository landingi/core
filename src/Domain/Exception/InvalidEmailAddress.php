<?php
declare(strict_types=1);

namespace Landingi\Shared\Domain\Exception;

class InvalidEmailAddress extends DomainException
{
    public static function invalidFormat($address, \Throwable $previous = null)
    {
        return new self("Given address: '$address' is invalid", 0, $previous);
    }

    public static function mailboxCannotBeNumber($address)
    {
        return new self("Email mailbox (first part) cannot be number. Given address: '$address'");
    }
}
