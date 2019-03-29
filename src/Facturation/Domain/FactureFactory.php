<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Facturation\Domain\Facture;
use HM\Facturation\Domain\ClientView\ClientId;
use HM\Facturation\Domain\Facture\NumeroFacture;
use HM\Facturation\Domain\FactureRepository;
use HM\Facturation\Domain\Facture\Date;
use HM\Facturation\Domain\Facture\ReglesPaiement\Echeance;
use HM\Facturation\Domain\Facture\ReglesPaiement\Escompte;
use HM\Facturation\Domain\Facture\ReglesPaiement\PenaliteRetard;
use HM\Facturation\Domain\Facture\Reference;
use HM\Facturation\Domain\Facture\ReglesPaiement;
use HM\Facturation\Domain\Facture\TVA;

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
     * @param Reference $reference
     * @param Date $date
     *
     * @return Facture
     */
    public function creerFacture(ClientId $clientId, Reference $reference, Date $date): Facture
    {
        $anneeCourante = $date->getAnnee();
        $nombreFacture = $this->factureRepository->getNombrePourLAnnee($anneeCourante);
        $numeroFacture = NumeroFacture::fromDateEtNombre($date, $nombreFacture);
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
