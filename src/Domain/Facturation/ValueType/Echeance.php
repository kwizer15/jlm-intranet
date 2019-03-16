<?php

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\Exception\DomainException;
use HM\Domain\Common\ValueType\IntegerValueType;

final class Echeance extends IntegerValueType
{
    public static function fromJours(int $jours): Echeance
    {
        /** @var Echeance $echeance */
        $echeance = self::fromInt($jours);

        return $echeance;
    }

    protected static function validate(int $candidate): void
    {
        if ($candidate < 0) {
            throw new DomainException('L\'échéance doit être supérieur à 0 jours.');
        }
    }
}
