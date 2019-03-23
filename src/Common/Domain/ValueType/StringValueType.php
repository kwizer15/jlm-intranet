<?php

declare(strict_types=1);

namespace HM\Common\Domain\ValueType;

use HM\Common\Domain\Exception\DomainException;
use HM\Common\Domain\ValueType\ValueType;

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
