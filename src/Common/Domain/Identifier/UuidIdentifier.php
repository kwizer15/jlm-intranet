<?php

declare(strict_types=1);

namespace HM\Common\Domain\Identifier;

use HM\Common\Domain\Identifier\Identifier;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidIdentifier implements Identifier
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
     * @return UuidIdentifier
     *
     * @throws \Exception
     */
    public static function generate(): UuidIdentifier
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @param string $id
     *
     * @return Identifier
     */
    public static function fromString(string $id): Identifier
    {
        return new static(Uuid::fromString($id));
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid->toString();
    }
}
