<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Event;

class LigneRepositionnee
{
    /**
     * @var string
     */
    private $ligneId;

    /**
     * @var int
     */
    private $anciennePosition;

    /**
     * @var int
     */
    private $nouvellePosition;

    public function __construct(string $ligneId, int $anciennePosition, int $nouvellePosition)
    {
        $this->ligneId = $ligneId;
        $this->anciennePosition = $anciennePosition;
        $this->nouvellePosition = $nouvellePosition;
    }

    /**
     * @return string
     */
    public function getLigneId(): string
    {
        return $this->ligneId;
    }

    /**
     * @return int
     */
    public function getAnciennePosition(): int
    {
        return $this->anciennePosition;
    }

    /**
     * @return int
     */
    public function getNouvellePosition(): int
    {
        return $this->nouvellePosition;
    }
}
