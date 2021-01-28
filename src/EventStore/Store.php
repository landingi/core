<?php
declare(strict_types=1);

namespace Landingi\Core\EventStore;

interface Store
{
    public function storeEvent(Event $event): void;
}
