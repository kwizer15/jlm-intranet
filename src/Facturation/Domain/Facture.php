<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\EventSourcing\EventSourcedAggregateRoot;
use HM\Facturation\Domain\Event\LigneAjoutee;
use HM\Facturation\Domain\Event\LigneRetiree;
use HM\Facturation\Domain\Facture\Destinataire;
use HM\Facturation\Domain\Facture\Ligne;
use HM\Facturation\Domain\Facture\Ligne\Description;
use HM\Facturation\Domain\Facture\Ligne\Designation;
use HM\Facturation\Domain\Facture\Ligne\LigneId;
use HM\Facturation\Domain\Facture\Ligne\Prix;
use HM\Facturation\Domain\Facture\Ligne\Quantite;
use HM\Facturation\Domain\Facture\Ligne\ReferenceProduit;
use HM\Facturation\Domain\Event\FactureEtablie;
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
     * @var int
     */
    private $compteurLignes;

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->numeroFacture;
    }

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
    public static function etablirFacture(
        NumeroFacture $numeroFacture,
        Date $date,
        Destinataire $destinataire,
        Reference $reference,
        ReglesPaiement $reglesPaiment,
        TVA $tvaApplicable
    ): Facture {
        $adresseDeFacturation = $destinataire->getAdresseDeFacturation();

        $event = new FactureEtablie(
            $numeroFacture->toString(),
            $date->toString(),
            $destinataire->getClientId()->toString(),
            $destinataire->getClientNom()->toString(),
            $destinataire->getNumeroCompteClient()->toString(),
            $adresseDeFacturation->getRue(),
            $adresseDeFacturation->getCodePostal(),
            $adresseDeFacturation->getVille(),
            $reference->toString(),
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

        $this->addChildEntity(Ligne::creerLigne(
            LigneId::generate(),
            $this->compteurLignes,
            $referenceProduit,
            $designation,
            $description,
            $prixUnitaire,
            $quantite,
            $tva
        ));

        return $this;
    }

    public function retirerLigne(LigneId $ligneId): Facture
    {
        $event = new LigneRetiree($ligneId->toString());
        $this->apply($event);

        return $this;
    }

        /**
     * @param FactureEtablie $event
     */
    protected function whenFactureCreee(FactureEtablie $event): void
    {
        $this->numeroFacture = NumeroFacture::fromString($event->getNumeroFacture());
    }

    /**
     * @param LigneAjoutee $event
     */
    protected function whenLigneAjoutee(LigneAjoutee $event): void
    {
        $this->compteurLignes++;
    }
}
