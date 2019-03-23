<?php

declare(strict_types=1);

namespace Tests\HM\Domain\Common;

use PHPUnit\Framework\TestCase;
use Tests\HM\Domain\Common\Fixtures\SimpleEventSourcedAggregateRoot;
use Tests\HM\Domain\Common\Fixtures\SimpleStringIdentifier;

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
