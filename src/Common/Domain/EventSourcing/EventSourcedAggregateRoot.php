<?php

declare(strict_types=1);

namespace HM\Common\Domain\EventSourcing;

use HM\Common\Domain\AggregateRoot\AggregateRoot;
use HM\Common\Domain\Event\Event;
use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\EventStream;
use HM\Common\Domain\Event\Metadata;

abstract class EventSourcedAggregateRoot implements AggregateRoot
{
    /**
     * @var EventStream
     */
    private $uncommitedEvents = [];

    /**
     * @var int
     */
    private $playHead = -1;

    /**
     * @var iterable
     */
    private $childEntities = [];

    /**
     * @return EventStream
     */
    final public function getUncommitedEvents(): EventStream
    {
        $eventStream = new InMemoryEventStream(...$this->uncommitedEvents);
        $this->uncommitedEvents = [];

        return $eventStream;
    }

    /**
     * @param Event $event
     *
     * @return AggregateRoot
     */
    final public function apply(Event $event): AggregateRoot
    {
        $this->handleRecursively($event);

        ++$this->playHead;
        $this->uncommitedEvents[] = EventMessage::recordNow(
            $this->getAggregateRootId(),
            $this->playHead,
            new Metadata([]),
            $event
        );

        return $this;
    }

    /**
     * @param EventStream $stream
     *
     * @return EventSourcedAggregateRoot
     *
     * @throws \Exception
     */
    final public static function reconstitute(EventStream $stream): EventSourcedAggregateRoot
    {
        $aggregate = new static();

        /** @var EventMessage $message */
        foreach ($stream as $message) {
            ++$aggregate->playHead;
            if ($aggregate->playHead !== $message->getPlayHead()) {
                throw new \Exception();
            }
            $aggregate->handleRecursively($message->getPayload());
        }

        return $aggregate;
    }

    /**
     * @return int
     */
    final public function getPlayHead(): int
    {
        return $this->playHead;
    }

    /**
     * @return EventSourcedEntity[]
     */
    protected function getChildEntities(): iterable
    {
        return $this->childEntities;
    }

    final protected function __construct()
    {
    }

    /**
     * @param EventSourcedEntity $entity
     */
    final protected function addChildEntity(EventSourcedEntity $entity): void
    {
        $this->childEntities = $entity;
    }

    /**
     * @param Event $event
     */
    final protected function handleRecursively(Event $event): void
    {
        $this->handle($event);

        foreach ($this->getChildEntities() as $entity) {
            if (!$entity instanceof EventSourcedEntity) {
                throw new NotEventSourcedEntityRegisteredException(
                    \get_class($entity).' must extends '.EventSourcedEntity::class
                );
            }
            $entity->registerAggregateRoot($this);
            $entity->handleRecursively($event);
        }
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
