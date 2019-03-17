<?php

namespace HM\Domain\Facturation\Identities;

use HM\Domain\Common\Identities\StringIdentity;
use HM\Domain\Facturation\ValueType\Date;

class NumeroFacture extends StringIdentity
{
    public static function fromDateEtNombre(Date $aujourdHui, int $nombre): NumeroFacture
    {
        $anneeMois = $aujourdHui->getAnneeCourte().$aujourdHui->getNumeroMois();
        $numero = (string) ($nombre + 1);
        $numeroFormate = str_pad($numero, 4, '0', STR_PAD_LEFT);

        return self::fromString($anneeMois.$numeroFormate);
    }
}
