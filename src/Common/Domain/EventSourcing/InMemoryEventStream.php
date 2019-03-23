<?php

declare(strict_types=1);

namespace HM\Common\Domain\EventSourcing;

use ArrayIterator;
use IteratorAggregate;
use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\EventStream;

class InMemoryEventStream implements IteratorAggregate, EventStream
{
    /**
     * @var array
     */
    private $events;

    /**
     * @param EventMessage ...$events
     */
    public function __construct(EventMessage ...$events)
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
