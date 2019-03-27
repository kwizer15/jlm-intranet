<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\ProduitView;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\ValueType\StringValueType;

class Reference extends StringValueType implements AggregateRootId
{

}
