<?php

declare(strict_types=1);

namespace HM\Common\Domain\Identifier;

interface Identifier
{
    /**
     * @param string $id
     *
     * @return Identifier
     */
    public static function fromString(string $id): Identifier;

    /**
     * @return string
     */
    public function toString(): string;
}