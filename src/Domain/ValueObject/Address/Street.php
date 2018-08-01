<?php
/**
 * Created by PhpStorm.
 * User: kwizer
 * Date: 01/08/18
 * Time: 23:12
 */

namespace HM\Domain\ValueObject\Address;

use HM\Domain\ValueObject\Address\Street\Number;
use HM\Domain\ValueObject\Address\Street\Way;

final class Street
{
    /**
     * @var Number
     */
    private $number;

    /**
     * @var Way
     */
    private $way;

    /**
     * WayLabel constructor.
     * @param Number $number
     * @param Way $way
     */
    private function __construct(Number $number, Way $way)
    {
        $this->number = $number;
        $this->way = $way;
    }

    public static function withValue(Number $number, Way $way): self
    {
        return new self($number, $way);
    }

    public function value(): string
    {
        return trim("{$number->value()} {$this->way->value()}");
    }
}