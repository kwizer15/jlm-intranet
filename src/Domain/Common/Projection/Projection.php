<?php

namespace HM\Domain\Common\Projection;

use HM\Domain\Common\Event\Event;
use HM\Domain\Common\Identities\Identity;

interface Projection
{
    /**
     * @param Event $event
     *
     * @return Projection
     */
    public function apply(Event $event): Projection;
}
