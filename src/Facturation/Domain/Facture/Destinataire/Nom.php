<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture\Destinataire;

use HM\Common\Domain\Exception\DomainException;
use HM\Common\Domain\ValueType\StringValueType;

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
