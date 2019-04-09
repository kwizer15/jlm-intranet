<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture;

use HM\Common\Domain\ValueType\PercentValueType;

final class TVA extends PercentValueType
{
    private const NORMALE = '20.0%';
    private const REDUITE = '5.5%';

    /**
     * @return TVA
     */
    public static function reduite(): TVA
    {
        return self::fromString(self::REDUITE);
    }

    /**
     * @return TVA
     */
    public static function normale(): TVA
    {
        return self::fromString(self::NORMALE);
    }
}
