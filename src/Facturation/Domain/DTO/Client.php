<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\DTO;

use HM\Common\Domain\DTO\DTO;
use HM\Common\Domain\Identifier\Identifier;
use HM\Facturation\Domain\Identifier\ClientId;
use HM\Facturation\Domain\ValueType\AdressePostale;
use HM\Facturation\Domain\ValueType\Nom;
use HM\Facturation\Domain\ValueType\NumeroCompte;

class Client implements DTO
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
     * @return Identifier
     */
    public function id(): Identifier
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
}
