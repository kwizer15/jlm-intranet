<?php

namespace HM\Domain\Common\Entity;

use HM\Domain\Common\Event\EventStream;
use HM\Domain\Common\Identities\Identity;

interface AggregateRoot extends Entity
{
    /**
     * @return Identity
     */
    public function getAggregateId(): Identity;

    /**
     * @return EventStream
     */
    public function getUncommitedEvents(): EventStream;
}