<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\Repository\Repository;
use HM\Facturation\Domain\ProduitView;
use HM\Facturation\Domain\ProduitView\Reference;

interface ProduitViewRepository extends Repository
{
    public function get(Reference $referenceProduit): ProduitView;
}
