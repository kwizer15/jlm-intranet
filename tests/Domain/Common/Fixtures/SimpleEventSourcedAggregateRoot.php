<?php

declare(strict_types=1);

namespace Tests\HM\Domain\Common\Fixtures;

use HM\Domain\Common\EventSourcing\EventSourcedAggregateRoot;
use HM\Domain\Common\Exception\DomainException;
use HM\Domain\Common\Identifier\Identifier;

class SimpleEventSourcedAggregateRoot extends EventSourcedAggregateRoot
{
    /**
     * @var SimpleStringIdentifier
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @param SimpleStringIdentifier $id
     * @param string $name
     *
     * @return SimpleEventSourcedAggregateRoot
     */
    public static function createMe(SimpleStringIdentifier $id, string $name): SimpleEventSourcedAggregateRoot
    {
        return (new self())->apply(new SimpleIamCreated($id->toString(), $name));
    }

    /**
     * @param string $name
     *
     * @return SimpleStringIdentifier
     */
    public function changeName(string $name): SimpleEventSourcedAggregateRoot
    {
        return $this->apply(new SimpleNameChanged($this->name, $name));
    }

    /**
     * @param SimpleIamCreated $event
     */
    protected function whenSimpleIamCreated(SimpleIamCreated $event): void
    {
        $this->id = SimpleStringIdentifier::fromString($event->getId());
        $this->name = $event->getName();
    }

    protected function whenSimpleNameChanged(SimpleNameChanged $event): void
    {
        if ($event->getOldName() !== $this->name) {
            throw new DomainException('Data incoherence');
        }
        $this->name = $event->getNewName();
    }

    /**
     * @return \HM\Domain\Common\AggregateRoot\AggregateRootId
     */
    public function getAggregateRootId(): Identifier
    {
        return $this->id;
    }
}
