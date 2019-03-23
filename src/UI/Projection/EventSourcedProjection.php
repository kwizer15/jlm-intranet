<?php

declare(strict_types=1);

namespace HM\UI\Projection;

use HM\Domain\Common\DomainEvent\DomainEvent;

abstract class EventSourcedProjection implements Projection
{
    /**
     * @param DomainEvent $event
     *
     * @return Projection
     */
    final public function apply(DomainEvent $event): Projection
    {
        $classParts = explode('\\', \get_class($event));

        $method = 'when'.end($classParts);

        if (!method_exists($this, $method)) {
            return $this;
        }

        $this->$method($event);

        return $this;
    }
}
