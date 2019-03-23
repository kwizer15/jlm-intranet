<?php

declare(strict_types=1);

namespace Tests\HM\Common\Application\CommandBus\Fixtures;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandResponse;
use HM\Common\Application\CommandBus\CommandBus;
use HM\Common\Application\CommandBus\CommandBusMiddleware;

class EchoMiddleware implements CommandBusMiddleware
{
    /**
     * @var string
     */
    private $before;

    /**
     * @var string
     */
    private $after;

    /**
     * @param string $before
     * @param string $after
     */
    public function __construct(string $before, string $after)
    {
        $this->before = $before;
        $this->after = $after;
    }

    /**
     * @param Command $command
     * @param CommandBus $bus
     *
     * @return CommandResponse
     */
    public function process(Command $command, CommandBus $bus): CommandResponse
    {
        echo $this->before;
        $response = $bus->dispatch($command);
        echo $this->after;

        return $response;
    }
}
