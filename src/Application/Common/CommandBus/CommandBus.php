<?php

declare(strict_types=1);

namespace HM\Application\Common\CommandBus;

use HM\Application\Common\Command\Command;
use HM\Domain\Common\DomainEvent\DomainEventStream;

interface CommandBus
{

    /**
     * @param Command $command
     *
     * @return DomainEventStream
     */
    public function dispatch(Command $command): DomainEventStream;
}
