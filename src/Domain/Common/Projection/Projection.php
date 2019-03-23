<?php

declare(strict_types=1);

namespace HM\Domain\Common\Projection;

use HM\Domain\Common\DomainEvent\DomainEvent;

interface Projection
{
    /**
     * @param DomainEvent $event
     *
     * @return Projection
     */
    public function apply(DomainEvent $event): Projection;
}
