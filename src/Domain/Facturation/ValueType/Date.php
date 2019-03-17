<?php

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\ValueType\ValueType;

final class Date implements ValueType
{
    private const DEFAULT_FORMAT = 'Y-m-d';

    /**
     * @var \DateTimeInterface
     */
    private $date;

    public static function aujourdHui(): Date
    {
        return new self(new \DateTimeImmutable());
    }

    /**
     * @param \DateTimeInterface $date
     *
     * @return Date
     */
    public function fromDateTime(\DateTimeInterface $date): Date
    {
        return new self($date);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function toDateTimeImmutable(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     */
    private function __construct(\DateTimeInterface $date)
    {
        if ($date instanceof \DateTime) {
            $date = \DateTimeImmutable::createFromMutable($date);
        }
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->date->format(self::DEFAULT_FORMAT);
    }

    public function getAnnee(): int
    {
        return (int) $this->date->format('Y');
    }

    public function getAnneeCourte(): string
    {
        return $this->date->format('y');
    }

    public function getNumeroMois(): string
    {
        return $this->date->format('m');
    }
}
