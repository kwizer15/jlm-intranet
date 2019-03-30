<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Event;

use HM\Common\Domain\Event\Event;

final class FactureEtablie implements Event
{
    /**
     * @var string
     */
    private $numeroFacture;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientNom;

    /**
     * @var string
     */
    private $clientNumeroCompte;

    /**
     * @var string
     */
    private $adresseFacturationRue;

    /**
     * @var string
     */
    private $adresseCodePostal;

    /**
     * @var string
     */
    private $adresseVille;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $echeance;

    /**
     * @var string
     */
    private $escompte;

    /**
     * @var string
     */
    private $penaliteRetard;

    /**
     * @var string
     */
    private $tva;

    public function __construct(
        string $numeroFacture,
        string $date,
        string $clientId,
        string $clientNom,
        string $clientNumeroCompte,
        string $adresseFacturationRue,
        string $adresseCodePostal,
        string $adresseVille,
        string $reference,
        int $echeance,
        string $escompte,
        string $penaliteRetard,
        string $tva
    ) {
        $this->numeroFacture = $numeroFacture;
        $this->date = $date;
        $this->clientId = $clientId;
        $this->clientNom = $clientNom;
        $this->clientNumeroCompte = $clientNumeroCompte;
        $this->adresseFacturationRue = $adresseFacturationRue;
        $this->adresseCodePostal = $adresseCodePostal;
        $this->adresseVille = $adresseVille;
        $this->reference = $reference;
        $this->echeance = $echeance;
        $this->escompte = $escompte;
        $this->penaliteRetard = $penaliteRetard;
        $this->tva = $tva;
    }

    /**
     * @return string
     */
    public function getNumeroFacture(): string
    {
        return $this->numeroFacture;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientNom(): string
    {
        return $this->clientNom;
    }

    /**
     * @return string
     */
    public function getClientNumeroCompte(): string
    {
        return $this->clientNumeroCompte;
    }

    /**
     * @return string
     */
    public function getAdresseFacturationRue(): string
    {
        return $this->adresseFacturationRue;
    }

    /**
     * @return string
     */
    public function getAdresseCodePostal(): string
    {
        return $this->adresseCodePostal;
    }

    /**
     * @return string
     */
    public function getAdresseVille(): string
    {
        return $this->adresseVille;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return int
     */
    public function getEcheance(): int
    {
        return $this->echeance;
    }

    /**
     * @return string
     */
    public function getEscompte(): string
    {
        return $this->escompte;
    }

    /**
     * @return string
     */
    public function getPenaliteRetard(): string
    {
        return $this->penaliteRetard;
    }

    /**
     * @return string
     */
    public function getTva(): string
    {
        return $this->tva;
    }
}
