<?php

declare(strict_types=1);

namespace HM\Domain\Facturation\Repository;

use HM\Domain\Facturation\Entity\Client;
use HM\Domain\Facturation\Identities\ClientId;
use HM\Domain\Common\Repository\Repository;

interface ClientRepository extends Repository
{
    public function get(ClientId $clientId): Client;
}
