<?php

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\ValueType\ValueType;

final class Date implements ValueType
{
    /**
     * @var \DateTimeInterface
     */
    private $date;

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
}
