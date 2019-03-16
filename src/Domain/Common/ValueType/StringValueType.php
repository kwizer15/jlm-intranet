<?php

namespace HM\Domain\Common\ValueType;

use HM\Domain\Common\Exception\DomainException;

abstract class StringValueType implements ValueType
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     *
     * @throws DomainException
     */
    protected static function validate(string $value): void
    {
    }

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        static::validate($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     *
     * @return StringValueType
     */
    final public static function fromString(string $value): StringValueType
    {
        return new static($value);
    }

    /**
     * @return string
     */
    final public function toString(): string
    {
        return $this->value;
    }
}
