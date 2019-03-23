<?php

declare(strict_types=1);

namespace Tests\HM\Common\Application\CommandBus;

use HM\Common\Application\CommandBus\CommandDispatcher;
use HM\Common\Application\CommandBus\MiddlewareCommandBusDecorator;
use PHPUnit\Framework\TestCase;
use Tests\HM\Common\Application\CommandBus\Fixtures\EchoMiddleware;
use Tests\HM\Common\Application\CommandBus\Fixtures\SimpleCommand;
use Tests\HM\Common\Application\CommandBus\Fixtures\SimpleCommandHandler;

class MiddlewareCommandBusDecoratorTest extends TestCase
{
    public function testCallOrder(): void
    {
        $bus = new MiddlewareCommandBusDecorator(
            new CommandDispatcher(
                new SimpleCommandHandler()
            ),
            new EchoMiddleware('1', '5'),
            new EchoMiddleware('2', '4')
        );

        $this->expectOutputString('12345');

        $bus->dispatch(new SimpleCommand('3'));
    }
}
