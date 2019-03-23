<?php

declare(strict_types=1);

namespace Tests\HM\Common\Domain\Fixtures;

use HM\Common\Domain\Event\Event;

class SimpleNameChanged implements Event
{
    /**
     * @var string
     */
    private $oldName;

    /**
     * @var string
     */
    private $newName;

    /**
     * @param string $oldName
     * @param string $newName
     */
    public function __construct(string $oldName, string $newName)
    {
        $this->oldName = $oldName;
        $this->newName = $newName;
    }

    /**
     * @return string
     */
    public function getOldName(): string
    {
        return $this->oldName;
    }

    /**
     * @return string
     */
    public function getNewName(): string
    {
        return $this->newName;
    }
}
