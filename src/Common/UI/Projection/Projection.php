<?php

declare(strict_types=1);

namespace HM\Common\UI\Projection;

use HM\Common\Domain\Event\Event;
use HM\Common\Domain\Event\EventStream;

interface Projection
{
    /**
     * @param Event $event
     *
     * @return Projection
     */
    public function apply(Event $event): Projection;

    /**
     * @return Projection
     */
    public function initialize(): Projection;

    /**
     * @return Projection
     */
    public function reset(): Projection;

    /**
     * @return Projection
     */
    public function delete(): Projection;

    /**
     * @param EventStream $eventStream
     *
     * @return Projection
     */
    public function recreate(EventStream $eventStream): Projection;
}
