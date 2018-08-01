<?php

namespace HM\Domain\ValueObject\Address\Street;

use HM\Domain\ValueObject\Address\Street\Way\Preposition;
use HM\Domain\ValueObject\Address\Street\Way\Type;

final class Way
{
    /**
     * @var Type
     */
    private $type;

    /**
     * @var Preposition
     */
    private $preposition;

    /**
     * @var string
     */
    private $name;

    /**
     * Way constructor.
     * @param Type $type
     * @param Preposition $preposition
     * @param string $name
     */
    private function __construct(Type $type, Preposition $preposition, string $name)
    {
        $this->type = $type;
        $this->preposition = $preposition;
        $this->name = $name;
    }

    /**
     * @param Type $type
     * @param Preposition $preposition
     * @param string $name
     * @return Way
     */
    public static function withValue(Type $type, Preposition $preposition, string $name): self
    {
        return new self($type, $preposition, $name);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return trim(trim("{$this->type->value()} {$this->preposition->value()}") . " {$this->name}");
    }
}