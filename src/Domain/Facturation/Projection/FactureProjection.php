<?php

declare(strict_types=1);

namespace HM\Domain\Facturation\Projection;

use HM\Domain\Common\Projection\AbstractProjection;
use HM\Domain\Facturation\Event\FactureCreee;

class FactureProjection extends AbstractProjection
{
    protected const MAP = [
        FactureCreee::class => 'applyFactureCreee',
    ];

    /**
     * @param FactureCreee $event
     *
     * @return FactureProjection
     */
    protected function applyFactureCreee(FactureCreee $event): FactureProjection
    {
        $facture = new self();
    }
}
