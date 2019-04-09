<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Event;

use HM\Common\Domain\Event\Event;

final class LigneAjoutee implements Event
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $designation;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $prixUnitaire;

    /**
     * @var float
     */
    private $quantite;

    /**
     * @var string
     */
    private $tva;

    /**
     * @var string
     */
    private $ligneId;

    /**
     * @var int
     */
    private $position;

    /**
     * @param string $ligneId
     * @param int $position
     * @param string $reference
     * @param string $designation
     * @param string $description
     * @param float $prixUnitaire
     * @param float $quantite
     * @param string $tva
     */
    public function __construct(
        string $ligneId,
        int $position,
        string $reference,
        string $designation,
        string $description,
        string $prixUnitaire,
        float $quantite,
        string $tva
    ) {
        $this->reference = $reference;
        $this->designation = $designation;
        $this->description = $description;
        $this->prixUnitaire = $prixUnitaire;
        $this->quantite = $quantite;
        $this->tva = $tva;
        $this->ligneId = $ligneId;
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getLigneId(): string
    {
        return $this->ligneId;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getDesignation(): string
    {
        return $this->designation;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPrixUnitaire(): string
    {
        return $this->prixUnitaire;
    }

    /**
     * @return float
     */
    public function getQuantite(): float
    {
        return $this->quantite;
    }

    /**
     * @return string
     */
    public function getTva(): string
    {
        return $this->tva;
    }
}
