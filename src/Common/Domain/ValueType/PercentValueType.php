<?php

declare(strict_types=1);

namespace HM\Common\Domain\ValueType;

abstract class PercentValueType extends DecimalValueType
{
    /**
     * @return float
     */
    final public function toCoefficient(): float
    {
        return $this->toFloat() / 100;
    }

    /**
     * @param string $value
     * @param string $decimalPoint
     * @param string $thousandsSeparator
     *
     * @return DecimalValueType
     */
    public static function fromFormat(
        string $value,
        string $decimalPoint = '.',
        string $thousandsSeparator = ','
    ): DecimalValueType {
        $exploded = explode($decimalPoint, $value);
        $precision = strlen(end($exploded)) - 1;
        $value = str_replace(['%', $thousandsSeparator], '', $value);

        return self::fromFloat((float) $value, $precision);
    }

    /**
     * @param string $decimalPoint
     * @param string $thousandsSeparator
     *
     * @return string
     */
    final public function format($decimalPoint = '.', $thousandsSeparator = ','): string
    {
        return parent::format($decimalPoint, $thousandsSeparator) . '%';
    }
}
