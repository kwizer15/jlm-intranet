<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Factory;

use HM\Facturation\Domain\AggregateRoot\Facture;
use HM\Facturation\Domain\Identifier\ClientId;
use HM\Facturation\Domain\Identifier\NumeroFacture;
use HM\Facturation\Domain\Repository\FactureRepository;
use HM\Facturation\Domain\ValueType\Date;
use HM\Facturation\Domain\ValueType\ReglesPaiement\Echeance;
use HM\Facturation\Domain\ValueType\ReglesPaiement\Escompte;
use HM\Facturation\Domain\ValueType\ReglesPaiement\PenaliteRetard;
use HM\Facturation\Domain\ValueType\Reference;
use HM\Facturation\Domain\ValueType\ReglesPaiement;
use HM\Facturation\Domain\ValueType\TVA;

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
        $reglesPaiment = ReglesPaiement::withRegles(
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
