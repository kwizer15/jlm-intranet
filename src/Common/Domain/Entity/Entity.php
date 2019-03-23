<?php

declare(strict_types=1);

namespace HM\Common\Domain\Entity;

interface Entity
{
    public function getEntityId(): EntityId;
}
