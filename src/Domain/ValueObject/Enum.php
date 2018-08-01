<?php

namespace HM\Domain\ValueObject;

abstract class Enum
{
    /**
     * @var string
     */
    private $value;

    /**
     * Enum constructor.
     * @param string $value
     * @throws BadValueException
     * @throws \ReflectionException
     */
    final private function __construct(string $value)
    {
        if (\in_array($value, static::list())) {
            throw new BadValueException();
        }
        $this->value = $value;
    }

    /**
     * @param $value
     * @return Enum
     * @throws BadValueException
     * @throws \ReflectionException
     */
    final public function withValue($value): Enum
    {
        return new static($value);
    }

    /**
     * @return string
     */
    final public function value(): string
    {
        return $this->value;
    }

    /**
     * @return iterable
     * @throws \ReflectionException
     */
    final public function list(): iterable
    {
        return (new \ReflectionClass(\get_class($this)))->getConstants();
    }
}