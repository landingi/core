<?php
declare(strict_types=1);

namespace Landingi\Core\EventStore;

final class Event
{
    private $name;
    private $data;
    private $aggregateName;
    private $aggregateUuid;
    private $createdAt;
    private $accountUuid;
    private $userUuid;
    private $sourceIp;
    private $subaccountUuid;

    public function __construct(
        EventName $name,
        EventData $data,
        AggregateName $aggregateName,
        AggregateUuid $aggregateUuid,
        AccountUuid $accountUuid,
        UserUuid $userUuid,
        ?SourceIp $sourceIp = null,
        ?AccountUuid $subaccountUuid = null
    ) {
        $this->name = $name;
        $this->data = $data;
        $this->aggregateName = $aggregateName;
        $this->aggregateUuid = $aggregateUuid;
        $this->createdAt = new CreatedAt(new \DateTime());
        $this->accountUuid = $accountUuid;
        $this->userUuid = $userUuid;
        $this->sourceIp = $sourceIp;
        $this->subaccountUuid = $subaccountUuid;
    }

    public function getName(): EventName
    {
        return $this->name;
    }

    public function getEventData(): EventData
    {
        return $this->data;
    }

    public function getAggregateName(): AggregateName
    {
        return $this->aggregateName;
    }

    public function getAggregateUuid(): AggregateUuid
    {
        return $this->aggregateUuid;
    }

    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function getAccountUuid(): AccountUuid
    {
        return $this->accountUuid;
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getSourceIp(): ?SourceIp
    {
        return $this->sourceIp;
    }

    public function getSubaccountUuid(): ?AccountUuid
    {
        return $this->subaccountUuid;
    }
}
