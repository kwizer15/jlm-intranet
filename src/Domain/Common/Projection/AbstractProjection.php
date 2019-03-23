<?php

declare(strict_types=1);

namespace HM\Domain\Common\Projection;

use HM\Domain\Common\DomainEvent\DomainEvent;
use HM\Domain\Common\DomainEvent\DomainEventStream;

class AbstractProjection implements Projection
{
    protected const MAP = [];

    final public function __construct(DomainEventStream $eventStream = null)
    {
        if (null !== $eventStream) {
            foreach ($eventStream as $event) {
                $this->apply($event);
            }
        }
    }

    /**
     * @param DomainEvent $event
     *
     * @return Projection
     */
    public function apply(DomainEvent $event): Projection
    {
        $eventClass = \get_class($event);
        if (!array_key_exists($eventClass, static::MAP)) {
            return $this;
        }

        $method = static::MAP[$eventClass];

        return $this->$method($event);
    }
}
