<?php

declare(strict_types=1);

namespace HM\Common\Domain\Serializer;

use HM\Common\Domain\Event\EventMessage;

interface Serializer
{
    /**
     * @param EventMessage $message
     *
     * @return array
     */
    public function serialize(EventMessage $message): array;

    /**
     * @param array $serializedMessage
     *
     * @return EventMessage
     */
    public function deserialize(array $serializedMessage): EventMessage;
}
