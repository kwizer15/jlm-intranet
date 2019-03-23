<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Factory;

use HM\Facturation\Domain\Identifier\ClientId;
use HM\Facturation\Domain\Repository\ClientRepository;
use HM\Facturation\Domain\Entity\Destinataire;

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
