<?php

namespace HM\Domain\Common\Identities;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidIdentity implements Identity
{
    /**
     * @var 
     */
    private $uuid;
    
    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return UuidIdentity
     *
     * @throws \Exception
     */
    public static function generate(): UuidIdentity
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param string $id
     *
     * @return Identity
     */
    public static function fromString(string $id): Identity
    {
        return new self(Uuid::fromString($id));
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid->toString();
    }
}
