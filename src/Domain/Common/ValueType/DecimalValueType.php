<?php

namespace HM\Domain\Common\ValueType;

use HM\Domain\Common\Exception\DomainException;

abstract class DecimalValueType
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var int
     */
    private $precision;

    /**
     * @param float $value
     *
     * @param int $precision
     */
    protected static function validate(float $value, int $precision): void
    {
        if ($precision < 0) {
            throw new DomainException('Precision must be greater than 0.');
        }
    }

    /**
     * @param float $value
     * @param int $precision
     */
    private function __construct(float $value, int $precision)
    {
        static::validate($value, $precision);
        $this->precision = $precision;
        $this->value = (int) ($value * 10 ** $precision);
    }

    /**
     * @param float $value
     * @param int $precision
     *
     * @return DecimalValueType
     */
    final public static function fromFloat(float $value, int $precision): DecimalValueType
    {
        return new static($value, $precision);
    }

    /**
     * @param string $value
     *
     * @return DecimalValueType
     */
    final public static function fromString(string $value): DecimalValueType
    {
        return self::fromFormat($value);
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
        $precision = strlen(end($exploded));
        $value = str_replace([$thousandsSeparator, $decimalPoint], '', $value);

        return new static($value, $precision);
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return $this->value / (10 ** $this->precision);
    }

    /**
     * @param string $decimalPoint
     * @param string $thousandsSeparator
     *
     * @return string
     */
    public function format($decimalPoint = '.', $thousandsSeparator = ','): string
    {
        return number_format($this->toFloat(), $this->precision, $decimalPoint, $thousandsSeparator);
    }

    /**
     * @return string
     */
    final public function toString(): string
    {
        return $this->format();
    }
}
