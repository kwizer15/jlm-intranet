<?php

declare(strict_types=1);

namespace HM\Common\Application\Event;

use HM\Common\Domain\Event\EventMessage;

interface EventListener
{
    public function handle(EventMessage $event);
}
