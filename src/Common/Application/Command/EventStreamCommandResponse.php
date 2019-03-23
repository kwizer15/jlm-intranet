<?php

declare(strict_types=1);

namespace HM\Common\Application\Command;

use HM\Common\Domain\Event\EventStream;

class EventStreamCommandResponse implements CommandResponse
{
    /**
     * @var EventStream
     */
    private $eventStream;

    /**
     * @param EventStream $eventStream
     */
    private function __construct(EventStream $eventStream)
    {
        $this->eventStream = $eventStream;
    }

    /**
     * @param EventStream $eventStream
     *
     * @return EventStreamCommandResponse
     */
    public static function withEventStream(EventStream $eventStream): EventStreamCommandResponse
    {
        return new self($eventStream);
    }

    /**
     * @return EventStream
     */
    public function getEventStream(): EventStream
    {
        return $this->eventStream;
    }
}
