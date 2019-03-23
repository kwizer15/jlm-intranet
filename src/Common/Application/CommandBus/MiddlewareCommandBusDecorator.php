<?php

declare(strict_types=1);

namespace HM\Common\Application\CommandBus;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandResponse;

class MiddlewareCommandBusDecorator implements CommandBus
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var CommandBusMiddleware[]
     */
    private $middlewares;

    /**
     * @param CommandBus $commandBus
     * @param CommandBusMiddleware ...$middlewares
     */
    public function __construct(CommandBus $commandBus, CommandBusMiddleware ...$middlewares)
    {
        $this->commandBus = $commandBus;
        $this->middlewares = $middlewares;
    }

    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function dispatch(Command $command): CommandResponse
    {
        $middleware = current($this->middlewares);
        if (false === $middleware) {
            reset($this->middlewares);

            return $this->commandBus->dispatch($command);
        }
        next($this->middlewares);

        return $middleware->process($command, $this);
    }
}
