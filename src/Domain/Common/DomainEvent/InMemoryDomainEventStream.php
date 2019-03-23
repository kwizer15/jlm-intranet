<?php

declare(strict_types=1);

namespace HM\Domain\Common\DomainEvent;

use ArrayIterator;
use IteratorAggregate;

class InMemoryDomainEventStream implements IteratorAggregate, DomainEventStream
{
    /**
     * @var array
     */
    private $events;

    /**
     * @param DomainMessage ...$events
     */
    public function __construct(DomainMessage ...$events)
    {
        $this->events = $events;
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->events);
    }
}
