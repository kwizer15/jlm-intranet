<?php

declare(strict_types=1);

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\ValueType\ValueType;

final class Date implements ValueType
{
    private const STRING_FORMAT = 'Y-m-d';

    /**
     * @var \DateTimeInterface
     */
    private $date;

    /**
     * @return Date
     *
     * @throws \Exception
     */
    public static function aujourdHui(): Date
    {
        return new self(new \DateTimeImmutable());
    }

    /**
     * @param \DateTimeInterface $date
     *
     * @return Date
     */
    public static function fromDateTime(\DateTimeInterface $date): Date
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
     * @return string
     */
    public function toString(): string
    {
        return $this->date->format(self::STRING_FORMAT);
    }

    /**
     * @return int
     */
    public function getAnnee(): int
    {
        return (int) $this->date->format('Y');
    }

    /**
     * @return string
     */
    public function getAnneeCourte(): string
    {
        return $this->date->format('y');
    }

    /**
     * @return string
     */
    public function getNumeroMois(): string
    {
        return $this->date->format('m');
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
}
