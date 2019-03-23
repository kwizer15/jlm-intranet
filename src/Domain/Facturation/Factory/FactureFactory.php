<?php

declare(strict_types=1);

namespace HM\Domain\Facturation\Factory;

use HM\Domain\Facturation\AggregateRoot\Facture;
use HM\Domain\Facturation\Identities\ClientId;
use HM\Domain\Facturation\Identities\NumeroFacture;
use HM\Domain\Facturation\Repository\FactureRepository;
use HM\Domain\Facturation\ValueType\Date;
use HM\Domain\Facturation\ValueType\Echeance;
use HM\Domain\Facturation\ValueType\Escompte;
use HM\Domain\Facturation\ValueType\PenaliteRetard;
use HM\Domain\Facturation\ValueType\Reference;
use HM\Domain\Facturation\ValueType\ReglesPaiment;
use HM\Domain\Facturation\ValueType\TVA;

class FactureFactory
{
    /**
     * @var FactureRepository
     */
    private $factureRepository;
    /**
     * @var DestinataireFactory
     */
    private $destinataireFactory;

    /**
     * @param FactureRepository $factureRepository
     * @param DestinataireFactory $destinataireFactory
     */
    public function __construct(FactureRepository $factureRepository, DestinataireFactory $destinataireFactory)
    {
        $this->factureRepository = $factureRepository;
        $this->destinataireFactory = $destinataireFactory;
    }

    /**
     * @param ClientId $clientId
     *
     * @param Reference $reference
     *
     * @param Date $date
     *
     * @return Facture
     */
    public function creerFacture(ClientId $clientId, Reference $reference, Date $date): Facture
    {
        $anneeCourante = $date->getAnnee();
        $nombreFacture = $this->factureRepository->getNombrePourLAnnee($anneeCourante);
        $numeroFacture = NumeroFacture::fromDateEtNombre($date, $nombreFacture + 1);
        $destinataire = $this->destinataireFactory->createFromClientId($clientId);
        $reglesPaiment = ReglesPaiment::withRegles(
            Echeance::fromJours(30),
            Escompte::fromString('0.00%'),
            PenaliteRetard::fromString('1.3%')
        );
        $tvaApplicable = TVA::fromString('20.0%');

        return Facture::creerFacture(
            $numeroFacture,
            $date,
            $destinataire,
            $reference,
            $reglesPaiment,
            $tvaApplicable
        );
    }
}
