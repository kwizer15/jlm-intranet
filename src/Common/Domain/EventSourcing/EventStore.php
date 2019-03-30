<?php

declare(strict_types=1);

namespace HM\Common\Domain\EventSourcing;

use HM\Common\Domain\Event\EventStream;

interface EventStore
{
    /**
     * @param string|null $aggregateType
     * @param string|null $aggregateId
     * @param int|null $maxPlayHead
     *
     * @return mixed
     */
    public function load(?string $aggregateType = null, ?string $aggregateId = null, ?int $maxPlayHead = null): EventStream;

    /**
     * @param EventStream $stream
     */
    public function append(EventStream $stream): void;
}
