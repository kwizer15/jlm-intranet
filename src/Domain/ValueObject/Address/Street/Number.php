<?php

namespace HM\Domain\ValueObject\Address\Street;

use HM\Domain\ValueObject\Address\Street\Number\RepetitionIndicator;
use HM\Domain\ValueObject\BadValueException;

final class Number
{
    /**
     * @var int
     */
    private $number;

    /**
     * @var RepetitionIndicator
     */
    private $repetitionIndicator;

    /**
     * Number constructor.
     * @param int $number
     * @param RepetitionIndicator $repetitionIndicator
     * @throws BadValueException
     */
    private function __construct(
        int $number = 0,
        ?RepetitionIndicator $repetitionIndicator = null
    ) {
        if ($number < 0) {
            throw new BadValueException('Number must be greater than 0');
        }
        $this->number = $number;
        $this->repetitionIndicator = $repetitionIndicator ?? RepetitionIndicator::NONE;
    }

    /**
     * @param int $number
     * @param RepetitionIndicator|null $repetitionIndicator
     * @return Number
     * @throws BadValueException
     */
    public static function withNumber(int $number = 0, ?RepetitionIndicator $repetitionIndicator = null): self
    {
        return new self($number, $repetitionIndicator);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        $number = 0 === $this->number ? '' : (string) $this->number;
        return trim($number . ' ' . $this->repetitionIndicator->value());
    }
}