<?php

declare(strict_types=1);

namespace HM\Common\Application\Command;

class AsyncCommandResponse implements CommandResponse
{
    private function __construct()
    {
    }

    public static function accepted(): AsyncCommandResponse
    {
        return new self();
    }
}
