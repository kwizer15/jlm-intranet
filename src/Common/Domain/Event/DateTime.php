<?php

declare(strict_types=1);

namespace HM\Common\Domain\Event;

use DateTimeImmutable;
use DateTimeZone;
use HM\Common\Domain\ValueType\ValueType;

class DateTime implements ValueType
{
    private const FORMAT_STRING = 'Y-m-d\TH:i:s.uP';

    /**
     * @var DateTimeImmutable
     */
    private $dateTime;

    /**
     * @param DateTimeImmutable $dateTime
     */
    private function __construct(\DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return DateTime
     */
    public static function now(): DateTime
    {
        return new self(
            DateTimeImmutable::createFromFormat(
                'U.u',
                sprintf('%.6F', microtime(true)),
                new DateTimeZone('UTC')
            )
        );
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->dateTime->format(self::FORMAT_STRING);
    }

    /**
     * @param string $dateTimeString
     *
     * @return DateTime
     * @throws \Exception
     */
    public static function fromString(string $dateTimeString): self
    {
        return new self(new DateTimeImmutable($dateTimeString));
    }
}
