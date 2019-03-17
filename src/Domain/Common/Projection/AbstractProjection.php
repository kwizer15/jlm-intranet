<?php

namespace HM\Domain\Common\Projection;

use HM\Domain\Common\Event\Event;
use HM\Domain\Common\Event\EventStream;

class AbstractProjection implements Projection
{
    protected const MAP = [];

    final public function __construct(EventStream $eventStream = null)
    {
        if (null !== $eventStream) {
            foreach ($eventStream as $event) {
                $this->apply($event);
            }
        }
    }

    /**
     * @param Event $event
     *
     * @return Projection
     */
    public function apply(Event $event): Projection
    {
        $eventClass = \get_class($event);
        if (!array_key_exists($eventClass, static::MAP)) {
            return $this;
        }

        $method = static::MAP[$eventClass];

        return $this->$method($event);
    }
}
