<?php

declare(strict_types=1);

namespace HM\Common\Application\CommandBus;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandResponse;

interface CommandBus
{
    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function dispatch(Command $command): CommandResponse;
}
