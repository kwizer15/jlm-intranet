<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture;

use HM\Common\Domain\EventSourcing\EventSourcedEntity;
use HM\Facturation\Domain\Event\LigneAjoutee;
use HM\Facturation\Domain\Facture\Ligne\Description;
use HM\Facturation\Domain\Facture\Ligne\Designation;
use HM\Facturation\Domain\Facture\Ligne\LigneId;
use HM\Facturation\Domain\Facture\Ligne\Prix;
use HM\Facturation\Domain\Facture\Ligne\Quantite;
use HM\Facturation\Domain\Facture\Ligne\ReferenceProduit;

final class Ligne extends EventSourcedEntity
{
    public static function creerLigne(
        LigneId $id,
        int $position,
        ReferenceProduit $reference,
        Designation $designation,
        Description $description,
        Prix $prixUnitaire,
        Quantite $quantite,
        TVA $tva
    ): Ligne {
        $event = new LigneAjoutee(
            $id->toString(),
            $position,
            $reference->toString(),
            $designation->toString(),
            $description->toString(),
            $prixUnitaire->toFloat(),
            $quantite->toFloat(),
            $tva->toString()
        );

        return (new self())->apply($event);
    }

    protected function whenLigneAjoutee(LigneAjoutee $event): void
    {

    }
}
