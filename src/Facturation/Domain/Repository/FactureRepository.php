<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Repository;

use HM\Common\Domain\Repository\Repository;
use HM\Facturation\Domain\AggregateRoot\Facture;

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
