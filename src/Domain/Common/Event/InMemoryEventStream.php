<?php

namespace HM\Domain\Common\Event;

class InMemoryEventStream implements EventStream, \IteratorAggregate
{
    /**
     * @var array
     */
    private $events;

    /**
     * @param array $events
     */
    public function __construct(array $events = [])
    {
        foreach ($events as $event) {
            if (!$event instanceof Event) {
                throw new \LogicException(sprintf('EventStream can contain only %s objects.', Event::class));
            }
        }

        $this->events = $events;
    }

    /**
     * @param Event $event
     *
     * @return EventStream
     */
    public function append(Event $event): EventStream
    {
        $events = $this->events;
        $events[] = $event;

        return new self($events);
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        $events = $this->events;
        return new \ArrayIterator($events);
    }
}
