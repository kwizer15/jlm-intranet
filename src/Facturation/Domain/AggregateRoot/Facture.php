<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\AggregateRoot;

use HM\Common\Domain\AggregateRoot\AggregateRootId;
use HM\Common\Domain\EventSourcing\EventSourcedAggregateRoot;
use HM\Facturation\Domain\Entity\Destinataire;
use HM\Facturation\Domain\Event\FactureCreee;
use HM\Facturation\Domain\Identifier\NumeroFacture;
use HM\Facturation\Domain\ValueType\Date;
use HM\Facturation\Domain\ValueType\Reference;
use HM\Facturation\Domain\ValueType\ReglesPaiement;
use HM\Facturation\Domain\ValueType\TVA;

class Facture extends EventSourcedAggregateRoot
{
    /**
     * @var NumeroFacture
     */
    private $numeroFacture;

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
            $reglesPaiment->getEcheance()->toInt(),
            $reglesPaiment->getEscompte()->toString(),
            $reglesPaiment->getPenaliteRetard()->toString(),
            $tvaApplicable->toString()
        );

        return (new self())->apply($event);
    }

    /**
     * @param FactureCreee $event
     */
    public function whenFactureCreee(FactureCreee $event): void
    {
        $this->numeroFacture = $event->getNumeroFacture();
    }

    /**
     * @return AggregateRootId
     */
    public function getAggregateRootId(): AggregateRootId
    {
        return $this->numeroFacture;
    }
}
