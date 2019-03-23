<?php

declare(strict_types=1);

namespace HM\Common\Application\EventBus;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandResponse;
use HM\Common\Application\Command\EventStreamCommandResponse;
use HM\Common\Application\CommandBus\CommandBus;
use HM\Common\Application\CommandBus\CommandBusMiddleware;

class EventBusCommandBusMiddleware implements CommandBusMiddleware
{
    /**
     * @var EventBus
     */
    private $eventBus;

    public function __construct(EventBus $eventDispatcher)
    {
        $this->eventBus = $eventDispatcher;
    }

    /**
     * @param Command $command
     * @param CommandBus $bus
     *
     * @return CommandResponse
     */
    public function process(Command $command, CommandBus $bus): CommandResponse
    {
        $response = $bus->dispatch($command);

        if ($response instanceof EventStreamCommandResponse) {
            $this->eventBus->publish($response->getEventStream());
        }

        return $response;
    }
}
