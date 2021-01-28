<?php
declare(strict_types=1);

namespace Landingi\Core\EventStore;

interface EventListener
{
    public function onEvent(Event $event): void;
}
