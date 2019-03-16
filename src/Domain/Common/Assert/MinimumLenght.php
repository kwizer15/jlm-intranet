<?php

namespace HM\Domain\Common\Assert;

class MinimumLenght extends AbstractLenght
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'minimum';
    }

    /**
     * @param int $expectedLenght
     * @param int $currentLenght
     *
     * @return bool
     */
    protected function rule(int $expectedLenght, int $currentLenght): bool
    {
        return $currentLenght < $expectedLenght;
    }

    /**
     * @return string
     */
    protected function getMessage(): string
    {
        return 'Too short value (fixed %d, %d given)';
    }
}
