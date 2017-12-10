<?php
declare(strict_types=1);

namespace Landingi\Shared\Domain;

use Landingi\Shared\Domain\Exception\InvalidEmailAddress;

final class Email
{
    private $address;

    /**
     * @param string $address
     *
     * @throws \Landingi\Shared\Domain\Exception\InvalidEmailAddress
     */
    public function __construct(string $address)
    {
        if (false === filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailAddress::invalidFormat($address);
        }

        if (is_numeric(explode('@', $address)[0])) {
            throw InvalidEmailAddress::mailboxCannotBeNumber($address);
        }

        $this->address = $address;
    }

    public function __toString()
    {
        return $this->address;
    }

    public function getHost() : string
    {
        return explode('@', $this->address)[1];
    }
}
