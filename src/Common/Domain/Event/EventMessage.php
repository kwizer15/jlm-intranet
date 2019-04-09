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
     * @var string
     */
    private $aggregateType;

    /**
     * @var int
     */
    private $playHead;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var string
     */
    private $type;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var DateTime
     */
    private $recordedOn;

    /**
     * @param string $aggregateRootId
     * @param string $aggregateType
     * @param int $playHead
     * @param Metadata $metadata
     * @param Event $event
     * @param DateTime $recordedOn
     */
    public function __construct(
        string $aggregateRootId,
        string $aggregateType,
        int $playHead,
        Metadata $metadata,
        Event $event,
        DateTime $recordedOn
    )
    {
        $this->aggregateRootId = $aggregateRootId;
        $this->aggregateType = $this->normalize($aggregateType);
        $this->playHead = $playHead;
        $this->metadata = $metadata;
        $this->type = $this->normalize(\get_class($event));
        $this->event = $event;
        $this->recordedOn = $recordedOn;
    }

    /**
     * @param AggregateRootId $aggregateRootId
     * @param string $aggregateType
     * @param int $playHead
     * @param Metadata $metadata
     * @param Event $event
     *
     * @return EventMessage
     */
    public static function recordNow(
        AggregateRootId $aggregateRootId,
        string $aggregateType,
        int $playHead,
        Metadata $metadata,
        Event $event
    ): EventMessage {
        return new self($aggregateRootId->toString(), $aggregateType, $playHead, $metadata, $event, DateTime::now());
    }

    /**
     * @return string
     */
    public function getAggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    /**
     * @return string
     */
    public function getAggregateType(): string
    {
        return $this->aggregateType;
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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function isType(string $type): bool
    {
        return $type === $this->type;
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

    /**
     * @param string $className
     *
     * @return string
     */
    private function normalize(string $className): string
    {
        return $className;
    }
}
