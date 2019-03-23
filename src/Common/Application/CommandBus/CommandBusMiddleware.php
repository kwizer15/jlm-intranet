<?php

declare(strict_types=1);

namespace HM\Common\Application\CommandBus;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandResponse;

interface CommandBusMiddleware
{
    /**
     * @param Command $command
     * @param CommandBus $bus
     *
     * @return CommandResponse
     */
    public function process(Command $command, CommandBus $bus): CommandResponse;
}
