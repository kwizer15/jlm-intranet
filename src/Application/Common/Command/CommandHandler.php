<?php

declare(strict_types=1);

namespace HM\Application\Common\Command;

use HM\Domain\Common\DomainEvent\DomainEvent;
use HM\Domain\Common\DomainEvent\DomainEventStream;

interface CommandHandler
{
    /**
     * @param Command $command
     *
     * @return DomainEventStream
     */
    public function handle(Command $command): DomainEventStream;

    /**
     * @return string
     */
    public static function listenTo(): string;
}
