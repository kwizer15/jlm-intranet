<?php

namespace HM\Domain\Facturation\Repository;

interface FactureRepository extends Repository
{
    public function getNombrePourLAnnee(int $annee): int;
}
