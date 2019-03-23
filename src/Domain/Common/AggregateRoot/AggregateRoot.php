<?php

declare(strict_types=1);

namespace HM\Domain\Common\AggregateRoot;

use HM\Domain\Common\Entity\Entity;
use HM\Domain\Common\DomainEvent\DomainEventStream;
use HM\Domain\Common\Identifier\Identifier;

interface AggregateRoot extends Entity
{
    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): Identifier;

    /**
     * @return DomainEventStream
     */
    public function getUncommitedEvents(): DomainEventStream;
}