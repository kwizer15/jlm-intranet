<?php

namespace HM\Domain\Facturation\Entity;

use HM\Domain\Common\Entity\Entity;
use HM\Domain\Common\Identities\Identity;
use HM\Domain\Facturation\Identities\ClientId;
use HM\Domain\Facturation\ValueType\AdressePostale;
use HM\Domain\Facturation\ValueType\Nom;
use HM\Domain\Facturation\ValueType\NumeroCompteClient;

class Client implements Entity
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
     * @var NumeroCompteClient
     */
    private $numeroCompteClient;

    /**
     * @var AdressePostale
     */
    private $adresseFacturation;

    /**
     * @param ClientId $id
     * @param Nom $nom
     * @param NumeroCompteClient $numeroCompteClient
     * @param AdressePostale $adresseFacturation
     */
    private function __construct(
        ClientId $id,
        Nom $nom,
        NumeroCompteClient $numeroCompteClient,
        AdressePostale $adresseFacturation
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->numeroCompteClient = $numeroCompteClient;
        $this->adresseFacturation = $adresseFacturation;
    }

    /**
     * @return Identity
     */
    public function id(): Identity
    {
        return $this->id;
    }

    /**
     * @return Nom
     */
    public function getNom(): Nom
    {
        return $this->nom;
    }

    /**
     * @return NumeroCompteClient
     */
    public function getNumeroCompteClient(): NumeroCompteClient
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
}
