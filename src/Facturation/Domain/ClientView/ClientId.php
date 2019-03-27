<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\ClientView;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\Identifier\UuidIdentifier;

class ClientId extends UuidIdentifier implements AggregateRootId
{

}
