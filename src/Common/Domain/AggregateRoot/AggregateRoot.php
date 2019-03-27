<?php

declare(strict_types=1);

namespace HM\Common\Domain\AggregateRoot;

interface AggregateRoot
{
    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId;
}