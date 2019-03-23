<?php

declare(strict_types=1);

namespace HM\Domain\Facturation\Repository;

use HM\Domain\Facturation\AggregateRoot\Facture;
use HM\Domain\Common\Repository\Repository;

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
}
