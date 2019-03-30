<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\Repository\Repository;
use HM\Facturation\Domain\Facture;
use HM\Facturation\Domain\Facture\NumeroFacture;

interface FactureRepository extends Repository
{
    /**
     * @param int $annee
     *
     * @return int
     */
    public function getNombrePourLAnnee(int $annee): int;

    /**
     * @param Facture $facture
     *
     * @return void
     */
    public function add(Facture $facture): void;

    /**
     * @param NumeroFacture $numeroFacture
     *
     * @return Facture
     */
    public function get(NumeroFacture $numeroFacture): Facture;
}
