<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture\Ligne;

use HM\Common\Domain\Entity\EntityId;
use HM\Common\Domain\Identifier\UuidIdentifier;

final class LigneId extends UuidIdentifier implements EntityId
{
}
