<?php

namespace HM\Domain\Common\Assert;

use HM\Domain\Common\Exception\Assert\AssertRuleException;
use HM\Domain\Common\Exception\Assert\TooShortException;
use HM\Domain\Common\Exception\DomainException;

abstract class AbstractLenght implements Assertion
{
    /**
     * @var int
     */
    private $lenght;

    /**
     * @return string
     */
    abstract protected function getName(): string;

    /**
     * @param int $expectedLenght
     * @param int $currentLenght
     *
     * @return bool
     */
    abstract protected function rule(int $expectedLenght, int $currentLenght): bool;

    /**
     * @return string
     */
    abstract protected function getMessage(): string;

    /**
     * @param int $lenght
     */
    final public function __construct(int $lenght)
    {
        if ($lenght < 0) {
            throw new AssertRuleException("Rule for {$this->getName()} lenght with length {$lenght} can not exists.");
        }

        $this->lenght = $lenght;
    }

    /**
     * @param $candidate
     *
     * @param string|null $message
     */
    final public function assert($candidate, ?string $message = null): void
    {
        if (\is_string($candidate)) {
            $currentLenght = mb_strlen($candidate);
            if ($this->rule($this->lenght, $currentLenght)) {
                $message = $message ?? $this->getMessage();
                throw new DomainException(sprintf($message, $this->lenght, mb_strlen($candidate)));
            }
        }
    }
}
