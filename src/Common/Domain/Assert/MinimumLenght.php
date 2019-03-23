<?php

declare(strict_types=1);

namespace HM\Common\Domain\Assert;

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
