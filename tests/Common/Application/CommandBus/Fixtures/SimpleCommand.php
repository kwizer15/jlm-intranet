<?php

declare(strict_types=1);

namespace Tests\HM\Common\Application\CommandBus\Fixtures;

use HM\Common\Application\Command\Command;

class SimpleCommand implements Command
{
    /**
     * @var string
     */
    private $simpleMessage;

    /**
     * @param string $simpleMessage
     */
    public function __construct(string $simpleMessage)
    {
        $this->simpleMessage = $simpleMessage;
    }

    /**
     * @return string
     */
    public function getSimpleMessage(): string
    {
        return $this->simpleMessage;
    }
}
