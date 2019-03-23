<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\ValueType;

use HM\Common\Domain\Assert\Assert;
use HM\Common\Domain\Assert\FixedLenght;
use HM\Common\Domain\Assert\OnlyDecimal;
use HM\Common\Domain\Exception\DomainException;
use HM\Common\Domain\ValueType\StringValueType;

final class NumeroCompte extends StringValueType
{
    /**
     * @param string $value
     *
     * @throws DomainException
     */
    protected static function validate(string $value): void
    {
        Assert::than($value)
            ->is(new FixedLenght(7))
            ->is(new OnlyDecimal())
        ;
    }
}
