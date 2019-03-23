<?php

declare(strict_types=1);

namespace Tests\HM\Domain\Common\Fixtures;

use HM\Domain\Common\AggregateRoot\AggregateRootId;
use HM\Domain\Common\Identifier\StringIdentifier;

class SimpleStringIdentifier extends StringIdentifier implements AggregateRootId
{

}
