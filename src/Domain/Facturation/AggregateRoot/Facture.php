<?php

declare(strict_types=1);

namespace HM\Domain\Facturation\AggregateRoot;

use HM\Domain\Common\EventSourcing\EventSourcedAggregateRoot;
use HM\Domain\Common\Identifier\Identifier;
use HM\Domain\Facturation\Event\FactureCreee;
use HM\Domain\Facturation\Identities\NumeroFacture;
use HM\Domain\Facturation\ValueType\Date;
use HM\Domain\Facturation\ValueType\Destinataire;
use HM\Domain\Facturation\ValueType\Reference;
use HM\Domain\Facturation\ValueType\ReglesPaiment;
use HM\Domain\Facturation\ValueType\TVA;

class Facture extends EventSourcedAggregateRoot
{
    private $numeroFacture;

    /**
     * @param NumeroFacture $numeroFacture
     * @param Date $date
     * @param Destinataire $destinataire
     * @param Reference $reference
     * @param ReglesPaiment $reglesPaiment
     * @param TVA $tvaApplicable
     *
     * @return Facture
     */
    public static function creerFacture(
        NumeroFacture $numeroFacture,
        Date $date,
        Destinataire $destinataire,
        Reference $reference,
        ReglesPaiment $reglesPaiment,
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
     * @return Identifier
     */
    public function getAggregateRootId(): Identifier
    {
        return $this->numeroFacture;
    }
}
