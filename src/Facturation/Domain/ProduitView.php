<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\ViewModel\ViewModel;
use HM\Facturation\Domain\ProduitView\Description;
use HM\Facturation\Domain\ProduitView\Designation;
use HM\Facturation\Domain\ProduitView\Prix;
use HM\Facturation\Domain\ProduitView\Reference;

class ProduitView implements ViewModel
{
    /**
     * @var Reference
     */
    private $referenceProduit;

    /**
     * @var Designation
     */
    private $designation;

    /**
     * @var Description
     */
    private $description;

    /**
     * @var Prix
     */
    private $prixUnitaire;

    /**
     * @var bool
     */
    private $petiteFourniture;

    public function __construct(
        Reference $referenceProduit,
        Designation $designation,
        Description $description,
        Prix $prixUnitaire,
        bool $petiteFourniture
    ) {
        $this->referenceProduit = $referenceProduit;
        $this->designation = $designation;
        $this->description = $description;
        $this->prixUnitaire = $prixUnitaire;
        $this->petiteFourniture = $petiteFourniture;
    }

    /**
     * @return Reference
     */
    public function getReferenceProduit(): Reference
    {
        return $this->referenceProduit;
    }

    /**
     * @return Designation
     */
    public function getDesignation(): Designation
    {
        return $this->designation;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return Prix
     */
    public function getPrixUnitaire(): Prix
    {
        return $this->prixUnitaire;
    }

    /**
     * @return bool
     */
    public function isPetiteFourniture(): bool
    {
        return $this->petiteFourniture;
    }

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->getReferenceProduit();
    }
}
