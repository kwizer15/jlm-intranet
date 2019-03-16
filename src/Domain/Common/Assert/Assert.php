<?php

namespace HM\Domain\Common\Assert;

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
