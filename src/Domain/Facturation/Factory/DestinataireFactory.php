<?php

declare(strict_types=1);

namespace HM\Domain\Facturation\Factory;

use HM\Domain\Facturation\Identities\ClientId;
use HM\Domain\Facturation\Repository\ClientRepository;
use HM\Domain\Facturation\ValueType\Destinataire;

class DestinataireFactory
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ClientId $clientId
     *
     * @return Destinataire
     */
    public function createFromClientId(ClientId $clientId): Destinataire
    {
        $client = $this->repository->get($clientId);

        return Destinataire::withDestinataire(
            $clientId,
            $client->getNom(),
            $client->getNumeroCompteClient(),
            $client->getAdresseFacturation()
        );
    }
}
