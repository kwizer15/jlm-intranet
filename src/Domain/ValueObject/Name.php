<?php

namespace HM\Domain\ValueObject;

final class Name
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function withValue(string $value): self
    {
        // TODO: Controle (pas de nombres par ex.)
        return new self($value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}