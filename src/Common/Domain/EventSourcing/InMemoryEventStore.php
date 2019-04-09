<?php

declare(strict_types=1);

namespace HM\Common\Domain\EventSourcing;

use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\EventStream;

class InMemoryEventStore implements EventStore
{
    private $store = [];

    /**
     * @param EventMessage[] $store
     */
    public function __construct(iterable $store = [])
    {
        foreach ($store as $message) {
            $this->store = $message;
        }
    }

    /**
     * @param string|null $aggregateType
     * @param string|null $aggregateId
     * @param int|null $maxPlayHead
     *
     * @return mixed
     */
    public function load(
        ?string $aggregateType = null,
        ?string $aggregateId = null,
        ?int $maxPlayHead = null
    ): EventStream {
        if (null === $aggregateType) {
            return new InMemoryEventStore(...$this->store);
        }

        $stream = [];
        if (null === $aggregateId) {
            foreach ($this->store as $message) {
                if ($message->getAggregateType() === $aggregateType) {
                    $stream[] = $message;
                }
            }

            return new InMemoryEventStream(...$stream);
        }

        if (null === $maxPlayHead) {
            foreach ($this->store as $message) {
                if ($message->getAggregateType() === $aggregateType && $message->getAggregateRootId() === $aggregateId) {
                    $stream[] = $message;
                }
            }

            return new InMemoryEventStream(...$stream);
        }

        foreach ($this->store as $message) {
            if ($message->getAggregateType() === $aggregateType
                && $message->getAggregateId() === $aggregateId
                && $message->getPlayHead() >= $maxPlayHead
            ) {
                $stream[] = $message;
            }
        }

        return new InMemoryEventStream(...$stream);
    }

    /**
     * @param EventStream $stream
     */
    public function append(EventStream $stream): void
    {
        foreach ($stream as $message) {
            $this->store[] = $message;
        }
    }
}
