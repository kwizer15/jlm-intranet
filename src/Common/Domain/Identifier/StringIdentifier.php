<?php

declare(strict_types=1);

namespace HM\Common\Domain\Identifier;

use HM\Common\Domain\Identifier\Identifier;

class StringIdentifier implements Identifier
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
     * @return Identifier
     */
    public static function fromString(string $id): Identifier
    {
        return new static($id);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->id;
    }
}
