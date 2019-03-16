<?php

namespace HM\Domain\Common\Identities;

class StringIdentity implements Identity
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    private function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $id
     *
     * @return Identity
     */
    public static function fromString(string $id): Identity
    {
        return new self($id);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->id;
    }
}
