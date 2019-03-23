<?php

declare(strict_types=1);

namespace HM\Domain\Common\Assert;

use HM\Domain\Common\Exception\DomainException;

interface Assertion
{
    /**
     * @param $candidate
     * @param string $message
     *
     * @throws DomainException
     */
    public function assert($candidate, ?string $message = null): void;
}
