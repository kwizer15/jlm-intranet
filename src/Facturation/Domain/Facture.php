<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\EventSourcing\EventSourcedAggregateRoot;
use HM\Facturation\Domain\Facture\Destinataire;
use HM\Facturation\Domain\Facture\Ligne;
use HM\Facturation\Domain\Facture\Ligne\Description;
use HM\Facturation\Domain\Facture\Ligne\Designation;
use HM\Facturation\Domain\Facture\Ligne\Prix;
use HM\Facturation\Domain\Facture\Ligne\Quantite;
use HM\Facturation\Domain\Facture\Ligne\ReferenceProduit;
use HM\Facturation\Domain\Event\FactureCreee;
use HM\Facturation\Domain\Facture\NumeroFacture;
use HM\Facturation\Domain\Facture\Date;
use HM\Facturation\Domain\Facture\Reference;
use HM\Facturation\Domain\Facture\ReglesPaiement;
use HM\Facturation\Domain\Facture\TVA;

class Facture extends EventSourcedAggregateRoot
{
    /**
     * @var NumeroFacture
     */
    private $numeroFacture;

    /**
     * @var bool
     */
    private $referenceTravaux;

    /**
     * @var Ligne[]
     */
    private $lignes = [];

    /**
     * @param NumeroFacture $numeroFacture
     * @param Date $date
     * @param Destinataire $destinataire
     * @param Reference $reference
     * @param ReglesPaiement $reglesPaiment
     * @param TVA $tvaApplicable
     *
     * @return Facture
     */
    public static function creerFacture(
        NumeroFacture $numeroFacture,
        Date $date,
        Destinataire $destinataire,
        Reference $reference,
        ReglesPaiement $reglesPaiment,
        TVA $tvaApplicable
    ): Facture {
        $adresseDeFacturation = $destinataire->getAdresseDeFacturation();

        $event = new FactureCreee(
            $numeroFacture->toString(),
            $date->toString(),
            $destinataire->getClientId()->toString(),
            $destinataire->getClientNom()->toString(),
            $destinataire->getNumeroCompteClient()->toString(),
            $adresseDeFacturation->getRue(),
            $adresseDeFacturation->getCodePostal(),
            $adresseDeFacturation->getVille(),
            $reference->toString(),
            $reference->isTravaux(),
            $reglesPaiment->getEcheance()->toInt(),
            $reglesPaiment->getEscompte()->toString(),
            $reglesPaiment->getPenaliteRetard()->toString(),
            $tvaApplicable->toString()
        );

        return (new self())->apply($event);
    }

    public function ajouterLigne(
        ReferenceProduit $referenceProduit,
        Designation $designation,
        Description $description,
        Prix $prixUnitaire,
        Quantite $quantite,
        bool $petiteFourniture
    ): Facture {
        $tva = $this->referenceTravaux && !$petiteFourniture
            ? TVA::reduite()
            : TVA::normale()
        ;

        $this->lignes[] = Ligne::creerLigne(
            $this->numeroFacture,
            $referenceProduit,
            $designation,
            $description,
            $prixUnitaire,
            $quantite,
            $tva
        );

        return $this;
    }

    /**
     * @param FactureCreee $event
     */
    final protected function whenFactureCreee(FactureCreee $event): void
    {
        $this->numeroFacture = NumeroFacture::fromString($event->getNumeroFacture());
        $this->referenceTravaux = $event->isReferenceTravaux();
    }

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->numeroFacture;
    }

    public function getChildEntities(): iterable
    {
        return $this->lignes;
    }
}
