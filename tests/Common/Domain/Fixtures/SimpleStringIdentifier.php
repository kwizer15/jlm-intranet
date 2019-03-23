<?php

declare(strict_types=1);

namespace Tests\HM\Common\Domain\Fixtures;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\Identifier\StringIdentifier;

class SimpleStringIdentifier extends StringIdentifier implements AggregateRootId
{

}
