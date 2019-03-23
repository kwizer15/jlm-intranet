<?php

declare(strict_types=1);

namespace HM\Common\Domain\Assert;

interface Assertion
{
    /**
     * @param $candidate
     * @param string $message
     */
    public function assert($candidate, ?string $message = null): void;
}
