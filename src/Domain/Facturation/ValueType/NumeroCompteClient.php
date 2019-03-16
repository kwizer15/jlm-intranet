<?php

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\Assert\Assert;
use HM\Domain\Common\Assert\FixedLenght;
use HM\Domain\Common\Assert\OnlyDecimal;
use HM\Domain\Common\Exception\DomainException;
use HM\Domain\Common\ValueType\StringValueType;

final class NumeroCompteClient extends StringValueType
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
