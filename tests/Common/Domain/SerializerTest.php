<?php

declare(strict_types=1);

namespace Tests\HM\Common\Domain;

use HM\Common\Domain\Event\DateTime;
use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\Metadata;
use HM\Common\Domain\Serializer\ReflectionSerializer;
use Tests\HM\Common\Domain\Fixtures\SimpleIamCreated;

class SerializerTest
{
    public function testSerializedAndDeserializedEqualsToOrigin(): void
    {
        $serializer = new ReflectionSerializer();
        $event = new EventMessage(
            'test',
            SimpleIamCreated::class,
            0,
            new Metadata([]),
            new SimpleIamCreated('test', 'hello'),
            DateTime::now()
        );

        $serializedEvent = $serializer->serialize($event);
        $deserializedEvent = $serializer->deserialize($serializedEvent);

        $this->assertEquals($event, $deserializedEvent);
    }
}
