<?php

declare(strict_types=1);

namespace HM\Common\Domain\Assert;

use HM\Common\Domain\Exception\DomainException;

class OnlyDecimal implements Assertion
{
    /**
     * @param $candidate
     * @param string|null $message
     */
    public function assert($candidate, ?string $message = null): void
    {
        if (!\is_string($candidate)) {
            $type = \is_object($candidate) ? \get_class($candidate) : gettype($candidate);
            throw new DomainException("Value must be a string, {$type} given");
        }

        if (!preg_match('/^\d*$/', $candidate)) {
            $message = $message ?? 'Value must contains only decimal characters';
            throw new DomainException($message);
        }
    }
}
