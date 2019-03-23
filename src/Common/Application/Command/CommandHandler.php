<?php

declare(strict_types=1);

namespace HM\Common\Application\Command;

interface CommandHandler
{
    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function handle(Command $command): CommandResponse;
}
