<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Facturation\Domain\ClientView\ClientId;
use HM\Facturation\Domain\ClientViewRepository;
use HM\Facturation\Domain\Facture\Destinataire;

class DestinataireFactory
{
    /**
     * @var ClientViewRepository
     */
    private $repository;

    /**
     * @param ClientViewRepository $repository
     */
    public function __construct(ClientViewRepository $repository)
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
