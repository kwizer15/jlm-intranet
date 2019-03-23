<?php

declare(strict_types=1);

namespace HM\Domain\Common\DomainEvent;

use HM\Domain\Common\AggregateRoot\AggregateRootId;
use HM\Domain\Common\ValueType\DateTime;

class DomainMessage
{
    /**
     * @var AggregateRootId
     */
    private $aggregateRootId;

    /**
     * @var int
     */
    private $playHead;

    /**
     * @var \HM\Domain\Common\DomainEvent\Metadata
     */
    private $metadata;

    /**
     * @var DomainEvent
     */
    private $event;

    /**
     * @var DateTime
     */
    private $recordedOn;

    public function __construct(
        string $aggregateRootId,
        int $playHead,
        Metadata $metadata,
        DomainEvent $event,
        DateTime $recordedOn
    )
    {
        $this->aggregateRootId = $aggregateRootId;
        $this->playHead = $playHead;
        $this->metadata = $metadata;
        $this->event = $event;
        $this->recordedOn = $recordedOn;
    }

    /**
     * @param AggregateRootId $aggregateRootId
     * @param int $playHead
     * @param Metadata $metadata
     * @param DomainEvent $event
     *
     * @return DomainMessage
     */
    public static function recordNow(
        AggregateRootId $aggregateRootId,
        int $playHead,
        Metadata $metadata,
        DomainEvent $event
    ): DomainMessage {
        return new self($aggregateRootId->toString(), $playHead, $metadata, $event, DateTime::now());
    }

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->aggregateRootId;
    }

    /**
     * @return int
     */
    public function getPlayHead(): int
    {
        return $this->playHead;
    }

    /**
     * @return Metadata
     */
    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }

    public function getType(): string
    {
        return $this->event::NAME;
    }

    /**
     * @return DomainEvent
     */
    public function getPayload(): DomainEvent
    {
        return $this->event;
    }

    /**
     * @return DateTime
     */
    public function getRecordedOn(): DateTime
    {
        return $this->recordedOn;
    }
}
