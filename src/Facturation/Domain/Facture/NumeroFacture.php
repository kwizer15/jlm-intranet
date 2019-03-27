<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture;

use HM\Common\Domain\Identifier\StringIdentifier;
use HM\Facturation\Domain\Facture\Date;

final class NumeroFacture extends StringIdentifier
{
    public static function fromDateEtNombre(Date $aujourdHui, int $nombre): NumeroFacture
    {
        $anneeMois = $aujourdHui->getAnneeCourte().$aujourdHui->getNumeroMois();
        $numero = (string) ($nombre + 1);
        $numeroFormate = str_pad($numero, 4, '0', STR_PAD_LEFT);

        return self::fromString($anneeMois.$numeroFormate);
    }
}
