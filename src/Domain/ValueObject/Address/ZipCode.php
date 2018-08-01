<?php

namespace HM\Domain\ValueObject\Address;

use HM\Domain\ValueObject\BadValueException;

final class ZipCode
{
    /**
     * @var string
     */
    private $value;

    /**
     * ZipCode constructor.
     * @param string $value
     * @throws BadValueException
     */
    private function __construct(string $value)
    {
        if (!self::isValid($value)) {
            throw new BadValueException('Invalid zip code');
        }
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return ZipCode
     * @throws BadValueException
     */
    public static function withValue(string $value): self
    {
        return new self($value);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCounty(): string
    {
        return substr($this->value,0, strpos('97', $this->value) === 0 ? 3 : 2);
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        // TODO: test validitée
        return true;
    }
}