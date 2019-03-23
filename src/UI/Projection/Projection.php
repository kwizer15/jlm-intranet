<?php

declare(strict_types=1);

namespace HM\UI\Projection;

use HM\Domain\Common\DomainEvent\DomainEvent;

interface Projection
{
    /**
     * @param DomainEvent $event
     *
     * @return Projection
     */
    public function apply(DomainEvent $event): Projection;

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
}
