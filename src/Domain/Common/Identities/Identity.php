<?php

namespace HM\Domain\Common\Identities;

interface Identity
{
    /**
     * @param string $id
     *
     * @return Identity
     */
    public static function fromString(string $id): Identity;

    /**
     * @return string
     */
    public function toString(): string;
}