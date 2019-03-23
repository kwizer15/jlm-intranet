<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\ValueType\ReglesPaiement;

use HM\Common\Domain\Exception\DomainException;
use HM\Common\Domain\ValueType\IntegerValueType;

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
