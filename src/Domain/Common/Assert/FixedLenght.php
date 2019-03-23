<?php

declare(strict_types=1);

namespace HM\Domain\Common\Assert;

class FixedLenght extends AbstractLenght
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'fixed';
    }

    /**
     * @param int $expectedLenght
     * @param int $currentLenght
     *
     * @return bool
     */
    protected function rule(int $expectedLenght, int $currentLenght): bool
    {
        return $currentLenght !== $expectedLenght;
    }

    /**
     * @return string
     */
    protected function getMessage(): string
    {
        return 'Bad lenght value (fixed %d, %d given)';
    }
}
