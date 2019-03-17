<?php

namespace HM\Domain\Common\Event;

interface EventStream extends \Traversable
{
    /**
     * @param Event $event
     *
     * @return EventStream
     */
    public function append(Event $event): EventStream;
}
