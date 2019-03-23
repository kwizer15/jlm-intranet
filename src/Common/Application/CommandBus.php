<?php

declare(strict_types=1);

namespace HM\Common\Application;

interface CommandBus
{
    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function dispatch(Command $command): CommandResponse;
}
