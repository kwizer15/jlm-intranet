<?php

declare(strict_types=1);

namespace HM\Common\Domain\AggregateRoot;

use HM\Common\Domain\Event\EventStream;

interface EventSourcedAggregateRoot extends AggregateRoot
{
    /**
     * @return EventStream
     */
    public function getUncommitedEvents(): EventStream;

    /**
     * @return int
     */
    public function getPlayHead(): int;

    /**
     * @param EventStream $eventStream
     *
     * @return AggregateRoot
     */
    public static function reconstitute(EventStream $eventStream): AggregateRoot;
}
