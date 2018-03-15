<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue;

interface Transport
{
    /** @return array|Message[] */
    public function getMessages() : array;
    public function remove(Message $message) : void;
    public function retry(Message $message) : void;
}
