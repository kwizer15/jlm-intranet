<?php

declare(strict_types=1);

namespace HM\Domain\Common\EventSourcing;

use HM\Domain\Common\AggregateRoot\AggregateRoot;
use HM\Domain\Common\DomainEvent\DomainEvent;
use HM\Domain\Common\DomainEvent\DomainEventStream;
use HM\Domain\Common\DomainEvent\InMemoryDomainEventStream;
use HM\Domain\Common\DomainEvent\DomainMessage;
use HM\Domain\Common\DomainEvent\Metadata;

abstract class EventSourcedAggregateRoot implements AggregateRoot
{
    /**
     * @var DomainEventStream
     */
    private $uncommitedEvents = [];

    /**
     * @var int
     */
    private $playHead = -1;

    /**
     * @return DomainEventStream
     */
    final public function getUncommitedEvents(): DomainEventStream
    {
        $eventStream = new InMemoryDomainEventStream(...$this->uncommitedEvents);
        $this->uncommitedEvents = [];

        return $eventStream;
    }

    /**
     * @param DomainEvent $event
     *
     * @return AggregateRoot
     */
    final protected function apply(DomainEvent $event): AggregateRoot
    {
        $this->handle($event);

        ++$this->playHead;
        $this->uncommitedEvents[] = DomainMessage::recordNow(
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
     * @param DomainEvent $event
     */
    private function handle(DomainEvent $event): void
    {
        $applier = $this->getApplierMethod($event);

        if (!method_exists($this, $applier)) {
            return;
        }
        $this->$applier($event);
    }

    /**
     * @param DomainEvent $event
     *
     * @return string
     */
    private function getApplierMethod(DomainEvent $event): string
    {
        $classParts = explode('\\', \get_class($event));

        return 'when'.end($classParts);
    }
}
