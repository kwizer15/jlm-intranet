<?php

declare(strict_types=1);

namespace HM\Common\Domain\Serializer;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\Event\DateTime;
use HM\Common\Domain\Event\Event;
use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\Metadata;

class ReflectionSerializer implements Serializer
{
    /**
     * @var array
     */
    private $lastSerializedCache;

    /**
     * @var EventMessage
     */
    private $lastDeserializedCache;

    /**
     * @param EventMessage $message
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function serialize(EventMessage $message): array
    {
        if ($message === $this->lastDeserializedCache) {
            return $this->lastSerializedCache;
        }
        $this->lastDeserializedCache = $message;
        $this->lastSerializedCache = $this->serializeRecursively($message);

        return $this->lastSerializedCache;
    }

    /**
     * @param array $serializedMessage
     *
     * @return EventMessage
     * 
     * @throws \Exception
     */
    public function deserialize(array $serializedMessage): EventMessage
    {
        if ($serializedMessage === $this->lastSerializedCache) {
            return $this->lastDeserializedCache;
        }

        $this->lastSerializedCache = $serializedMessage;
        $this->lastDeserializedCache = new EventMessage(
            $serializedMessage['aggregateRootId'],
            $serializedMessage['aggregateType'],
            $serializedMessage['playHead'],
            new Metadata($serializedMessage['metadata']),
            $this->deserializeEvent($serializedMessage['type'], $serializedMessage['event']),
            DateTime::fromString($serializedMessage['recordedOn'])
        );

        return $this->lastDeserializedCache;
    }

    /**
     * @param $message
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    private function serializeRecursively($message)
    {
        $serialized = [];
        if (is_array($message)) {
            foreach ($message as $key => $value) {
                $serialized[$key] = $this->serializeRecursively($value);
            }
            return $serialized;
        }

        if (!is_object($message)) {
            return $message;
        }

        if ($message instanceof AggregateRootId || $message instanceof DateTime) {
            return $message->toString();
        }

        $class = new \ReflectionClass($message);
        $properties = $class->getProperties();
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $serialized[$propertyName] = $this->serializeRecursively($property->getValue($message));
            $property->setAccessible(false);
        }

        return $serialized;
    }

    /**
     * @param string $type
     * @param array $serializedEvent
     *
     * @return Event
     *
     * @throws \ReflectionException
     */
    private function deserializeEvent(string $type, array $serializedEvent): Event
    {
        if (!class_exists($type)) {
            throw new \RuntimeException(sprintf('Class %s not exists.', $type));
        }

        if (!\in_array(Event::class, class_implements($type, true), true)) {
            throw new \RuntimeException(sprintf('Class %s not implements %s.', $type, Event::class));
        }

        $reflectedEvent = new \ReflectionClass($type);
        /** @var Event $event */
        $event = $reflectedEvent->newInstanceWithoutConstructor();
        $properties = $reflectedEvent->getProperties();
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $property->setValue($event, $serializedEvent[$property->getName()]);
            $property->setAccessible(false);
        }

        return $event;
    }
}
