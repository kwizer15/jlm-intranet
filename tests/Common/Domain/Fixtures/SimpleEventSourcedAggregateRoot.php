<?php

declare(strict_types=1);

namespace Tests\HM\Common\Domain\Fixtures;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\Entity\EntityId;
use HM\Common\Domain\EventSourcing\EventSourcedAggregateRoot;
use HM\Common\Domain\Exception\DomainException;

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
     * @return SimpleEventSourcedAggregateRoot
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

    /**
     * @param SimpleNameChanged $event
     */
    protected function whenSimpleNameChanged(SimpleNameChanged $event): void
    {
        if ($event->getOldName() !== $this->name) {
            throw new DomainException('Data incoherence');
        }
        $this->name = $event->getNewName();
    }

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
