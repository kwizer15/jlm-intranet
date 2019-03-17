<?php

namespace HM\Domain\Common\Entity;

use HM\Domain\Common\Event\Event;
use HM\Domain\Common\Event\EventStream;
use HM\Domain\Common\Event\InMemoryEventStream;
use HM\Domain\Common\Identities\Identity;
use HM\Domain\Common\Projection\Projection;

abstract class AbstractAggregateRoot implements AggregateRoot
{
    protected const PROJECTION_CLASS = Projection::class;

    /**
     * @var EventStream|null
     */
    private $uncommitedEvents;

    /**
     * @var Projection|null
     */
    private $projection;

    /**
     * @var Identity
     */
    private $aggregateId;

    /**
     * @return EventStream
     */
    final public function getUncommitedEvents(): EventStream
    {
        return $this->uncommitedEvents;
    }

    /**
     * @return Projection
     */
    final protected function getProjection(): Projection
    {
        return $this->projection;
    }

    /**
     * @return Identity
     */
    final public function getAggregateId(): Identity
    {
        return $this->aggregateId;
    }

    /**
     * @param Identity $aggregateId
     * @param Projection|null $projection
     * @param EventStream|null $uncommitedEvents
     */
    final protected function __construct(Identity $aggregateId, ?Projection $projection = null, ?EventStream $uncommitedEvents = null)
    {
        if (null === $projection) {
            $projectionClass = static::PROJECTION_CLASS;
            $projection = new $projectionClass(new InMemoryEventStream());
        }
        $this->projection = $projection;
        $this->uncommitedEvents = $uncommitedEvents ?? new InMemoryEventStream();
        $this->aggregateId = $aggregateId;
    }

    /**
     * @param Event $event
     *
     * @return AggregateRoot
     */
    final protected function apply(Event $event): AggregateRoot
    {
        return new static($this->aggregateId, $this->projection->apply($event), $this->uncommitedEvents->append($event));
    }

    /**
     * @param Identity $aggregateId
     * @param EventStream $eventStream
     *
     * @return AggregateRoot
     */
    final public static function reconstitute(Identity $aggregateId, EventStream $eventStream): AggregateRoot
    {
        $projectionClass = static::PROJECTION_CLASS;
        $projection = new $projectionClass($eventStream);

        return new static($aggregateId, $projection);
    }
}
