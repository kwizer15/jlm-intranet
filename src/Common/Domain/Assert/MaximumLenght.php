<?php

declare(strict_types=1);

namespace HM\Common\Domain\Assert;

class MaximumLenght extends AbstractLenght
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'maximum';
    }

    /**
     * @param int $expectedLenght
     * @param int $currentLenght
     *
     * @return bool
     */
    protected function rule(int $expectedLenght, int $currentLenght): bool
    {
        return $currentLenght > $expectedLenght;
    }

    /**
     * @return string
     */
    protected function getMessage(): string
    {
        return 'Too long value (fixed %d, %d given)';
    }
}
