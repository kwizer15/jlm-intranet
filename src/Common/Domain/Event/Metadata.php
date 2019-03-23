<?php

declare(strict_types=1);

namespace HM\Common\Domain\Event;

class Metadata
{
    /**
     * @var array
     */
    private $metadata;

    /**
     * @param array $metadata
     */
    public function __construct(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }
}
