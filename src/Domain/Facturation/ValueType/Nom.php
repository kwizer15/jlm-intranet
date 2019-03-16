<?php

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\Exception\DomainException;
use HM\Domain\Common\ValueType\StringValueType;

final class Nom extends StringValueType
{
    /**
     * @param string $value
     *
     * @throws DomainException
     */
    protected static function validate(string $value): void
    {
        if (!preg_match('/^[A-ZÉÈÎÀÊÔÇa-zéèàîêôçù& \-]+$/u', $value)) {
            throw new DomainException(sprintf('%s est un nom incorrect.', $value));
        }
    }
}
