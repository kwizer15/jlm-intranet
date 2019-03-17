<?php

namespace HM\Domain\Facturation\Repository;

use HM\Domain\Facturation\Entity\Client;
use HM\Domain\Facturation\Identities\ClientId;

interface ClientRepository extends Repository
{
    public function get(ClientId $clientId): Client;
}
