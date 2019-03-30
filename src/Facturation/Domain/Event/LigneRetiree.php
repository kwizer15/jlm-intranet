<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Event;

class LigneRetiree
{
    /**
     * @var string
     */
    private $ligneId;

    /**
     * @param string $ligneId
     */
    public function __construct(string $ligneId)
    {
        $this->ligneId = $ligneId;
    }

    /**
     * @return string
     */
    public function getLigneId(): string
    {
        return $this->ligneId;
    }
}
