<?php

declare(strict_types=1);

namespace HM\Common\Domain\EventSourcing;

use HM\Common\Domain\Event\EventStream;
use HM\Common\Domain\Serializer\Serializer;

class FileEventStore implements EventStore
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var string
     */
    private $filename;

    /**
     * @param string $filename
     * @param Serializer $serializer
     */
    public function __construct(string $filename, Serializer $serializer)
    {
        $this->filename = $filename;
        $this->serializer = $serializer;
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
        return new FileEventStream($this->filename, $this->serializer, $aggregateType, $aggregateId, $maxPlayHead);
    }

    /**
     * @param EventStream $stream
     */
    public function append(EventStream $stream): void
    {
        $file = new \SplFileObject($this->filename, 'w');
        foreach ($stream as $eventMessage) {
            $file->fwrite(json_encode($this->serializer->serialize($eventMessage));
        }
    }
}
