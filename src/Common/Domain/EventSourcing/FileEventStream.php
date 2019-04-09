<?php

declare(strict_types=1);

namespace HM\Common\Domain\EventSourcing;

use HM\Common\Domain\Event\Event;
use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\EventStream;
use HM\Common\Domain\Serializer\Serializer;


class FileEventStream extends \FilterIterator implements EventStream
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var string
     */
    private $aggregateType;

    /**
     * @var string
     */
    private $aggregateId;

    /**
     * @var string
     */
    private $maxPlayHead;

    /**
     * @param string $filename
     * @param Serializer $serializer
     * @param string|null $aggregateType
     * @param string|null $aggregateId
     * @param string|null $maxPlayHead
     */
    public function __construct(
        string $filename,
        Serializer $serializer,
        string $aggregateType = null,
        string $aggregateId = null,
        string $maxPlayHead = null
    ) {
        $file = new \SplFileObject($filename, 'r');
        parent::__construct($file);
        $this->serializer = $serializer;
        $this->aggregateType = $aggregateType;
        $this->aggregateId = $aggregateId;
        $this->maxPlayHead = $maxPlayHead;
    }

    /**
     * @return EventMessage
     */
    public function current(): EventMessage
    {
        return $this->serializer->deserialize(json_decode(parent::current(), true));
    }

    public function valid(): bool
    {
        return !empty(parent::current());
    }

    /**
     * @return bool
     */
    public function accept(): bool
    {
        $current = json_decode(parent::current(), true);
        if (empty($current)) {
            return false;
        }

        if (null !== $this->aggregateType && $this->aggregateType !== $current['aggregateType']) {
            return false;
        }

        if (null !== $this->aggregateId && $this->aggregateId !== $current['aggregateRootId']) {
            return false;
        }

        if (null !== $this->maxPlayHead && $this->maxPlayHead > $current['playHead']) {
            return false;
        }

        return true;
    }
}
