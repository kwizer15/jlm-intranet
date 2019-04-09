<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\EventSourcing\EventSourcedAggregateRoot;
use HM\Common\Domain\EventSourcing\EventSourcedEntity;
use HM\Facturation\Domain\Event\LigneAjoutee;
use HM\Facturation\Domain\Event\LigneRepositionnee;
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
     * @var bool
     */
    private $hasMainDOeuvre = false;

    /**
     * @var Ligne[]
     */
    private $lignes = [];

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->numeroFacture;
    }

    /**
     * @return EventSourcedEntity[]
     */
    protected function getChildEntities(): iterable
    {
        return $this->lignes;
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

    /**
     * @param ReferenceProduit $referenceProduit
     * @param Designation $designation
     * @param Description $description
     * @param Prix $prixUnitaire
     * @param Quantite $quantite
     * @param bool $petiteFourniture
     *
     * @return Facture
     * @throws \Exception
     */
    public function ajouterLigne(
        ReferenceProduit $referenceProduit,
        Designation $designation,
        Description $description,
        Prix $prixUnitaire,
        Quantite $quantite,
        bool $petiteFourniture
    ): Facture {
        $tva = $this->hasMainDOeuvre && !$petiteFourniture
            ? TVA::reduite()
            : TVA::normale()
        ;

        $this->apply(new LigneAjoutee(
            LigneId::generate()->toString(),
            \count($this->lignes),
            $referenceProduit->toString(),
            $designation->toString(),
            $description->toString(),
            $prixUnitaire->toString(),
            $quantite->toFloat(),
            $tva->toString()
        ));

        return $this;
    }

    /**
     * @param LigneId $ligneId
     *
     * @return Facture
     */
    public function retirerLigne(LigneId $ligneId): Facture
    {
        $stringLigneId = $ligneId->toString();

        $reordonne = false;
        foreach ($this->lignes as $position => $ligne) {
            $id = $ligne->getEntityId()->toString();
            if ($reordonne) {
                $this->apply(new LigneRepositionnee($id, $position, $position - 1));
            }
            if ($id === $stringLigneId) {
                $reordonne = true;
                $this->apply(new LigneRetiree($id, $position));
            }
        }

        return $this;
    }

    /**
     * @param LigneId $ligneId
     * @param Designation $designation
     *
     * @return Facture
     */
    public function renommeProduit(LigneId $ligneId, Designation $designation):  Facture
    {
        $this->lignes[$ligneId]->renommeProduit($designation);

        return $this;
    }

    /**
     * @param FactureEtablie $event
     */
    protected function whenFactureEtablie(FactureEtablie $event): void
    {
        $this->numeroFacture = NumeroFacture::fromString($event->getNumeroFacture());
    }

    /**
     * @param LigneAjoutee $event
     */
    protected function whenLigneAjoutee(LigneAjoutee $event): void
    {
        $this->lignes[$event->getPosition()] = new Ligne();
    }

    /**
     * @param LigneRetiree $event
     */
    protected function whenLigneRetiree(LigneRetiree $event): void
    {
        unset($this->lignes[$event->getAnciennePosition()]);
    }

    /**
     * @param LigneRepositionnee $event
     */
    protected function whenLigneRepositionnee(LigneRepositionnee $event): void
    {
        unset($this->lignes[$event->getAnciennePosition()]);
        $this->lignes[$event->getNouvellePosition()] = $event->getLigneId();
    }
}
