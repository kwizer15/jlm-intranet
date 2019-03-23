<?php

declare(strict_types=1);

namespace Tests\HM\UI\Common;

use HM\Domain\Common\DomainEvent\DomainMessage;
use PHPUnit\Framework\TestCase;
use Tests\HM\Domain\Common\Fixtures\SimpleEventSourcedAggregateRoot;
use Tests\HM\Domain\Common\Fixtures\SimpleStringIdentifier;
use Tests\HM\UI\Common\Fixtures\SimpleProjection;

class SimpleProjectionTest extends TestCase
{
    public function testProjectionGetRightData(): void
    {
        $aggregate = SimpleEventSourcedAggregateRoot::createMe(SimpleStringIdentifier::fromString('yep'), 'myName');
        $aggregate->changeName('anOtherName');
        $eventStream = $aggregate->getUncommitedEvents();
        $projection = new SimpleProjection();

        /** @var DomainMessage $message */
        foreach ($eventStream as $message)
        {
            $projection->apply($message->getPayload());
        }

        $this->assertEquals('yep', $projection->getId());
        $this->assertEquals('anOtherName', $projection->getName());
    }
}
