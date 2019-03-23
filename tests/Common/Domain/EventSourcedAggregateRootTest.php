<?php

declare(strict_types=1);

namespace Tests\HM\Common\Domain;

use PHPUnit\Framework\TestCase;
use Tests\HM\Common\Domain\Fixtures\SimpleEventSourcedAggregateRoot;
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
}
