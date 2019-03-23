<?php

declare(strict_types=1);

namespace Tests\HM\Domain\Common\Fixtures;

use HM\Domain\Common\DomainEvent\DomainEvent;

class SimpleNameChanged implements DomainEvent
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
