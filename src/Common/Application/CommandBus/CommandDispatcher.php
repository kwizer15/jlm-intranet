<?php

declare(strict_types=1);

namespace HM\Common\Application\CommandBus;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandHandler;
use HM\Common\Application\Command\CommandResponse;

class CommandDispatcher implements CommandBus
{
    /**
     * @var CommandHandler[]
     */
    private $handlers;

    /**
     * @param CommandHandler ...$commandHandlers
     */
    public function __construct(CommandHandler ...$commandHandlers)
    {
        foreach ($commandHandlers as $commandHandler) {
            $commandClass = $this->getCommandClassFor($commandHandler);
            $this->handlers[$commandClass] = $commandHandler;
        }
    }

    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function dispatch(Command $command): CommandResponse
    {
        $commandClass = \get_class($command);
        if (!array_key_exists($commandClass, $this->handlers)) {
            throw new CommandNotFoundException($command);
        }

        $handler = $this->handlers[$commandClass];

        return $handler->handle($command);
    }

    /**
     * @param CommandHandler $commandHandler
     *
     * @return bool|string
     */
    private function getCommandClassFor(CommandHandler $commandHandler)
    {
        return substr(\get_class($commandHandler), 0, -strlen('Handler'));
    }
}
