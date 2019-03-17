<?php

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\ValueType\ValueType;
use HM\Domain\Facturation\Entity\Client;
use HM\Domain\Facturation\Identities\ClientId;

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
     * @var NumeroCompteClient
     */
    private $numeroCompteClient;

    /**
     * @var AdressePostale
     */
    private $adresseDeFacturation;

    /**
     * @param ClientId $clientId
     * @param Nom $clientNom
     * @param NumeroCompteClient $numeroCompteClient
     * @param AdressePostale $adresseDeFacturation
     */
    private function __construct(
        ClientId $clientId,
        Nom $clientNom,
        NumeroCompteClient $numeroCompteClient,
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
     * @param NumeroCompteClient $numeroCompteClient
     * @param AdressePostale $adresseDeFacturation
     *
     * @return Destinataire
     */
    public static function withDestinataire(
        ClientId $clientId,
        Nom $clientNom,
        NumeroCompteClient $numeroCompteClient,
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
     * @return NumeroCompteClient
     */
    public function getNumeroCompteClient(): NumeroCompteClient
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
