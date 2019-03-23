<?php

declare(strict_types=1);

namespace Tests\HM\Common\Application\CommandBus\Fixtures;

use HM\Common\Application\Command\AsyncCommandResponse;
use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandHandler;
use HM\Common\Application\Command\CommandResponse;

class SimpleCommandHandler implements CommandHandler
{
    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function handle(Command $command): CommandResponse
    {
        /** @var SimpleCommand $command */
        echo $command->getSimpleMessage();

        return AsyncCommandResponse::accepted();
    }
}
