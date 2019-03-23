<?php

declare(strict_types=1);

namespace HM\Common\Application\EventBus;

use HM\Common\Domain\Event\EventStream;

interface EventBus
{
    public function publish(EventStream $event);
}
