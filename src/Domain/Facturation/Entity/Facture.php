<?php

namespace HM\Domain\Facturation\Entity;

use HM\Domain\Common\Entity\AggregateRoot;
use HM\Domain\Common\Identities\Identity;
use HM\Domain\Facturation\Event\FactureCreee;
use HM\Domain\Facturation\Identities\ClientId;
use HM\Domain\Facturation\Identities\NumeroFacture;
use HM\Domain\Facturation\ValueType\AdressePostale;
use HM\Domain\Facturation\ValueType\Date;
use HM\Domain\Facturation\ValueType\Echeance;
use HM\Domain\Facturation\ValueType\Nom;
use HM\Domain\Facturation\ValueType\NumeroCompteClient;
use HM\Domain\Facturation\ValueType\Reference;

class Facture implements AggregateRoot
{
    /**
     * @var Identity
     */
    private $numeroFacture;

    /**
     * @var ClientId
     */
    private $clientId;

    /**
     * @param NumeroFacture $numeroFacture
     * @param Date $date
     * @param ClientId $clientId
     * @param Nom $clientNom
     * @param NumeroCompteClient $numeroCompteClient
     * @param AdressePostale $adresseDeFacturation
     */
    public function __construct(
        NumeroFacture $numeroFacture,
        Date $date,
        ClientId $clientId,
        Nom $clientNom,
        NumeroCompteClient $numeroCompteClient,
        AdressePostale $adresseDeFacturation
    ) {
        $this->numeroFacture = $numeroFacture;
        $this->clientId = $clientId;
    }

    /**
     * @return Identity
     */
    public function id(): Identity
    {
        return $this->numeroFacture;
    }

    /**
     * @param NumeroFacture $numeroFacture
     * @param Date $date
     * @param ClientId $clientId
     *
     * @param Nom $clientNom
     * @param NumeroCompteClient $numeroCompteClient
     * @param AdressePostale $adresseDeFacturation
     *
     * @param Reference $reference
     *
     * @param Echeance $echeance
     *
     * @return Facture
     */
    public function creerFacture(
        NumeroFacture $numeroFacture,
        Date $date,
        ClientId $clientId,
        Nom $clientNom,
        NumeroCompteClient $numeroCompteClient,
        AdressePostale $adresseDeFacturation,
        Reference $reference,
        Echeance $echeance
    ): Facture {
        $event = new FactureCreee(
            $numeroFacture->toString(),
            $date->toDateTimeImmutable(),
            $clientId->toString(),
            $clientNom->toString(),
            $numeroCompteClient->toString(),
            $adresseDeFacturation->getRue(),
            $adresseDeFacturation->getCodePostal(),
            $adresseDeFacturation->getVille(),
            $reference->toString(),
            $echeance->toInt(),

        );
    }
}
