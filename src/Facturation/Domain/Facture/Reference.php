<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture;

use HM\Common\Domain\ValueType\StringValueType;

final class Reference extends StringValueType
{
    private $travaux;

    /**
     * @return bool
     */
    public function isTravaux(): bool
    {
        return $this->travaux;
    }

    /**
     * @return Reference
     */
    public function withTravaux(): Reference
    {
        /** @var Reference $reference */
        $reference = self::fromString($this->toString());
        $reference->travaux = true;

        return $reference;
    }
}
