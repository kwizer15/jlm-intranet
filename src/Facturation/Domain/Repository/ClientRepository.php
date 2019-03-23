<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Repository;

use HM\Common\Domain\Repository\Repository;
use HM\Facturation\Domain\DTO\Client;
use HM\Facturation\Domain\Identifier\ClientId;

interface ClientRepository extends Repository
{
    public function get(ClientId $clientId): Client;
}
