<?php

declare(strict_types=1);

namespace HM\Common\Domain\Assert;

class Assert
{
    /**
     * @var mixed
     */
    private $candidate;

    /**
     * @param $candidate
     */
    private function __construct($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * @param mixed $candidate
     *
     * @return Assert
     */
    public static function than($candidate): Assert
    {
        return new self($candidate);
    }

    /**
     * @param Assertion $assertion
     *
     * @return Assert
     */
    public function is(Assertion $assertion): Assert
    {
        $assertion->assert($this->candidate);

        return $this;
    }
}
