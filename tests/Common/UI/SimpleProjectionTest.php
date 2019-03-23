<?php

declare(strict_types=1);

namespace Tests\HM\Common\UI;

use PHPUnit\Framework\TestCase;
use Tests\HM\Common\Domain\Fixtures\SimpleEventSourcedAggregateRoot;
use Tests\HM\Common\Domain\Fixtures\SimpleStringIdentifier;
use Tests\HM\Common\UI\Fixtures\SimpleProjection;

class SimpleProjectionTest extends TestCase
{
    public function testProjectionGetRightData(): void
    {
        $aggregate = SimpleEventSourcedAggregateRoot::createMe(SimpleStringIdentifier::fromString('yep'), 'myName');
        $aggregate->changeName('anOtherName');
        $projection = (new SimpleProjection())->recreate($aggregate->getUncommitedEvents());

        $this->assertEquals('yep', $projection->getId());
        $this->assertEquals('anOtherName', $projection->getName());
    }
}
