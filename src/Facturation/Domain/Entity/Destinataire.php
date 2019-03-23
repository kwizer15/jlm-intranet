<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Entity;

use HM\Common\Domain\ValueType\ValueType;
use HM\Facturation\Domain\Identifier\ClientId;
use HM\Facturation\Domain\ValueType\AdressePostale;
use HM\Facturation\Domain\ValueType\Nom;
use HM\Facturation\Domain\ValueType\NumeroCompte;

final class Destinataire implements ValueType
{
    /**
     * @var ClientId
     */
    private $clientId;

    /**
     * @var Nom
     */
    private $clientNom;

    /**
     * @var NumeroCompte
     */
    private $numeroCompteClient;

    /**
     * @var AdressePostale
     */
    private $adresseDeFacturation;

    /**
     * @param ClientId $clientId
     * @param Nom $clientNom
     * @param NumeroCompte $numeroCompteClient
     * @param AdressePostale $adresseDeFacturation
     */
    private function __construct(
        ClientId $clientId,
        Nom $clientNom,
        NumeroCompte $numeroCompteClient,
        AdressePostale $adresseDeFacturation
    ) {
        $this->clientId = $clientId;
        $this->clientNom = $clientNom;
        $this->numeroCompteClient = $numeroCompteClient;
        $this->adresseDeFacturation = $adresseDeFacturation;
    }

    /**
     * @param ClientId $clientId
     * @param Nom $clientNom
     * @param NumeroCompte $numeroCompteClient
     * @param AdressePostale $adresseDeFacturation
     *
     * @return Destinataire
     */
    public static function withDestinataire(
        ClientId $clientId,
        Nom $clientNom,
        NumeroCompte $numeroCompteClient,
        AdressePostale $adresseDeFacturation
    ): Destinataire {
        return new self($clientId, $clientNom, $numeroCompteClient, $adresseDeFacturation);
    }

    /**
     * @return ClientId
     */
    public function getClientId(): ClientId
    {
        return $this->clientId;
    }

    /**
     * @return Nom
     */
    public function getClientNom(): Nom
    {
        return $this->clientNom;
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
    public function getAdresseDeFacturation(): AdressePostale
    {
        return $this->adresseDeFacturation;
    }
}
