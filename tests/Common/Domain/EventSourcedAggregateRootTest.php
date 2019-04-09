<?php

declare(strict_types=1);

namespace Tests\HM\Common\Domain;

use HM\Common\Domain\Event\DateTime;
use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\Event\Metadata;
use HM\Common\Domain\EventSourcing\InMemoryEventStream;
use PHPUnit\Framework\TestCase;
use Tests\HM\Common\Domain\Fixtures\SimpleEventSourcedAggregateRoot;
use Tests\HM\Common\Domain\Fixtures\SimpleIamCreated;
use Tests\HM\Common\Domain\Fixtures\SimpleNameChanged;
use Tests\HM\Common\Domain\Fixtures\SimpleStringIdentifier;

class EventSourcedAggregateRootTest extends TestCase
{
    public function testCreateSimpleAggregate(): void
    {
        $aggregate = SimpleEventSourcedAggregateRoot::createMe(SimpleStringIdentifier::fromString('my_id'), 'my_name');
        $this->assertEquals(0, $aggregate->getPlayHead());

        $aggregate->changeName('my_other_name');
        $this->assertEquals(1, $aggregate->getPlayHead());

        $this->assertCount(2, $aggregate->getUncommitedEvents());
    }

    public function testUncommitedEventsIsClearAfterCall(): void
    {
        $aggregate = SimpleEventSourcedAggregateRoot::createMe(SimpleStringIdentifier::fromString('my_id'), 'my_name');
        $this->assertEquals(0, $aggregate->getPlayHead());

        $this->assertCount(1, $aggregate->getUncommitedEvents());
        $this->assertCount(0, $aggregate->getUncommitedEvents());
    }

    public function testReconstitute(): void
    {
        $eventStream = new InMemoryEventStream(
            new EventMessage('me', SimpleEventSourcedAggregateRoot::class, 0, new Metadata([]),  new SimpleIamCreated('me', 'myName'), DateTime::now()),
            new EventMessage('me', SimpleEventSourcedAggregateRoot::class, 1, new Metadata([]),  new SimpleNameChanged('myName', 'myNewName'), DateTime::now()),
            new EventMessage('me', SimpleEventSourcedAggregateRoot::class, 2, new Metadata([]),  new SimpleNameChanged('myNewName', 'ItsMe'), DateTime::now())
        );

        /** @var SimpleEventSourcedAggregateRoot $aggregate */
        $aggregate = SimpleEventSourcedAggregateRoot::reconstitute($eventStream);
        $this->assertEquals('ItsMe', $aggregate->getName());
        $this->assertCount(0, $aggregate->getUncommitedEvents());
    }

    public function testBadPlayHeadReconstitute(): void
    {
        $eventStream = new InMemoryEventStream(
            new EventMessage('me', SimpleEventSourcedAggregateRoot::class, 0, new Metadata([]),  new SimpleIamCreated('me', 'myName'), DateTime::now()),
            new EventMessage('me', SimpleEventSourcedAggregateRoot::class, 1, new Metadata([]),  new SimpleNameChanged('myName', 'myNewName'), DateTime::now()),
            new EventMessage('me', SimpleEventSourcedAggregateRoot::class, 1, new Metadata([]),  new SimpleNameChanged('myName', 'ItsMe'), DateTime::now())
        );

        $this->expectException(\Exception::class);
        /** @var SimpleEventSourcedAggregateRoot $aggregate */
        SimpleEventSourcedAggregateRoot::reconstitute($eventStream);
    }
}
