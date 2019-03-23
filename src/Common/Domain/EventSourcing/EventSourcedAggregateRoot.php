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
    final protected function apply(Event $event): AggregateRoot
    {
        $this->handle($event);

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
     * @return int
     */
    final public function getPlayHead(): int
    {
        return $this->playHead;
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
