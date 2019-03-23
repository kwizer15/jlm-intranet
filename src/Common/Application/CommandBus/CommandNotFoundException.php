<?php

declare(strict_types=1);

namespace HM\Common\Application\CommandBus;

use HM\Common\Application\Command\Command;

class CommandNotFoundException extends \RuntimeException
{
    public function __construct(Command $command)
    {
        parent::__construct('Class '.\get_class($command).'Handler not found.');
    }
}
