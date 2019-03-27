<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\Repository\Repository;
use HM\Facturation\Domain\ClientView;
use HM\Facturation\Domain\ClientView\ClientId;

interface ClientViewRepository extends Repository
{
    public function get(ClientId $clientId): ClientView;
}
