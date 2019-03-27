<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\AggregateRoot\AggregateRoot;
use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Facturation\Domain\ClientView\ClientId;
use HM\Facturation\Domain\Facture\Destinataire\AdressePostale;
use HM\Facturation\Domain\Facture\Destinataire\Nom;
use HM\Facturation\Domain\Facture\Destinataire\NumeroCompte;

class ClientView implements AggregateRoot
{
    /**
     * @var ClientId
     */
    private $id;

    /**
     * @var Nom
     */
    private $nom;

    /**
     * @var NumeroCompte
     */
    private $numeroCompteClient;

    /**
     * @var AdressePostale
     */
    private $adresseFacturation;

    /**
     * @param ClientId $id
     * @param Nom $nom
     * @param NumeroCompte $numeroCompteClient
     * @param AdressePostale $adresseFacturation
     */
    private function __construct(
        ClientId $id,
        Nom $nom,
        NumeroCompte $numeroCompteClient,
        AdressePostale $adresseFacturation
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->numeroCompteClient = $numeroCompteClient;
        $this->adresseFacturation = $adresseFacturation;
    }

    /**
     * @return Nom
     */
    public function getNom(): Nom
    {
        return $this->nom;
    }

    /**
     * @return NumeroCompte
     */
    public function getNumeroCompteClient(): NumeroCompte
    {
        return $this->numeroCompteClient;
    }

    /**
     * @return AdressePostale
     */
    public function getAdresseFacturation(): AdressePostale
    {
        return $this->adresseFacturation;
    }

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->id;
    }
}
