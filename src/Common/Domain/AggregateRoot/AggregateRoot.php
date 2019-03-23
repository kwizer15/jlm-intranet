<?php

declare(strict_types=1);

namespace HM\Common\Domain\AggregateRoot;

use HM\Common\Domain\Event\EventStream;
use HM\Common\Domain\Entity\Entity;

interface AggregateRoot
{
    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId;

    /**
     * @return EventStream
     */
    public function getUncommitedEvents(): EventStream;
}