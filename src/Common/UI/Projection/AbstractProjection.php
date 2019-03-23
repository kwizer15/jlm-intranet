<?php

declare(strict_types=1);

namespace HM\Common\UI\Projection;

use HM\Common\Domain\Event\Event;
use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\EventStream;

abstract class AbstractProjection implements Projection
{
    final public function recreate(EventStream $eventStream): Projection
    {
        $this->reset();
        /** @var EventMessage $eventMessage */
        foreach ($eventStream as $eventMessage) {
            $this->apply($eventMessage->getPayload());
        }

        return $this;
    }

    /**
     * @param Event $event
     *
     * @return Projection
     */
    final public function apply(Event $event): Projection
    {
        $method = $this->getApplierMethod($event);
        if (!method_exists($this, $method)) {
            return $this;
        }

        return $this->$method($event);
    }

    /**
     * @param Event $event
     *
     * @return string
     */
    private function getApplierMethod(Event $event): string
    {
        $classParts = explode('\\', \get_class($event));

        return 'when'.end($classParts);
    }
}
