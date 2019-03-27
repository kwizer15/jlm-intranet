<?php

declare(strict_types=1);

namespace HM\Common\Domain\EventSourcing;

use HM\Common\Domain\Event\Event;

abstract class EventSourcedEntity
{
    /**
     * @var EventSourcedAggregateRoot
     */
    private $aggregateRoot;

    /**
     * @var EventSourcedEntity[]
     */
    private $childEntities = [];

    /**
     * @param EventSourcedAggregateRoot $aggregateRoot
     */
    final public function registerAggregateRoot(EventSourcedAggregateRoot $aggregateRoot): void
    {
        if (null !== $this->aggregateRoot && $this->aggregateRoot !== $aggregateRoot) {
            throw new AggregateRootAlreadyRegisteredException();
        }
        $this->aggregateRoot = $aggregateRoot;
    }

    /**
     * @param Event $event
     */
    final public function handleRecursively(Event $event): void
    {
        $this->handle($event);

        foreach ($this->getChildEntities() as $entity) {
            if (!$entity instanceof self) {
                throw new NotEventSourcedEntityRegisteredException();
            }
            $entity->registerAggregateRoot($this->aggregateRoot);
            $entity->handleRecursively($event);
        }
    }

    final protected function __construct()
    {
    }

    /**
     * @param Event $event
     *
     * @return EventSourcedEntity
     */
    final protected function apply(Event $event): EventSourcedEntity
    {
        $this->aggregateRoot->apply($event);

        return $this;
    }

    /**
     * @param EventSourcedEntity $entity
     */
    final protected function addChildEntity(EventSourcedEntity $entity): void
    {
        $this->childEntities[] = $entity;
    }

    /**
     * @return EventSourcedEntity[]
     */
    final protected function getChildEntities(): iterable
    {
        return $this->childEntities;
    }

    /**
     * @param Event $event
     */
    private function handle(Event $event): void
    {
        $applier = $this->getApplierMethod($event);

        if (!method_exists($this, $applier)) {
            return;
        }
        $this->$applier($event);
    }

    /**
     * @param Event $event
     *
     * @return string
     */
    private function getApplierMethod(Event $event): string
    {
        $classParts = explode('\\', \get_class($event));

        return 'when'.end($classParts);
    }
}
