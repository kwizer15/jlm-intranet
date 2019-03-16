<?php

namespace HM\Domain\Common\ValueType;

abstract class PercentValueType extends DecimalValueType
{
    /**
     * @return float
     */
    final public function toPercent(): float
    {
        return parent::toFloat();
    }

    /**
     * @return float
     */
    final public function toFloat(): float
    {
        return $this->toPercent() / 100;
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
        $value = str_replace(['%', $thousandsSeparator, $decimalPoint], '', $value);

        return self::fromFloat($value, $precision);
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
