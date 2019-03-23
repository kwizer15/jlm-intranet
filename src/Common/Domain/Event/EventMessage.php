<?php

declare(strict_types=1);

namespace HM\Common\Domain\Event;

use HM\Common\Domain\AggregateRoot\AggregateRootId;

class EventMessage
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
     * @var Metadata
     */
    private $metadata;

    /**
     * @var Event
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
        Event $event,
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
     * @param Event $event
     *
     * @return EventMessage
     */
    public static function recordNow(
        AggregateRootId $aggregateRootId,
        int $playHead,
        Metadata $metadata,
        Event $event
    ): EventMessage {
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
     * @return Event
     */
    public function getPayload(): Event
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
