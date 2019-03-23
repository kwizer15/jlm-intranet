<?php

declare(strict_types=1);

namespace HM\Common\Domain\ValueType;

use HM\Common\Domain\Exception\DomainException;
use HM\Common\Domain\ValueType\ValueType;

abstract class IntegerValueType implements ValueType
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     *
     * @throws DomainException
     */
    protected static function validate(int $value): void
    {
    }

    /**
     * @param int $value
     */
    private function __construct(int $value)
    {
        static::validate($value);
        $this->value = $value;
    }

    /**
     * @param int $value
     *
     * @return IntegerValueType
     */
    final public static function fromInt(int $value): IntegerValueType
    {
        return new static($value);
    }

    /**
     * @return int
     */
    final public function toInt(): int
    {
        return $this->value;
    }
}
