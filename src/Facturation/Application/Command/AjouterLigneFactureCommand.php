<?php

declare(strict_types=1);

namespace HM\Facturation\Application\Command;

use HM\Common\Application\Command\Command;

class AjouterLigneFactureCommand implements Command
{
    /**
     * @var string
     */
    private $numeroFacture;

    /**
     * @var string
     */
    private $referenceProduit;

    /**
     * @var float
     */
    private $quantite;

    /**
     * @param string $numeroFacture
     * @param string $referenceProduit
     * @param float $quantite
     */
    public function __construct(string $numeroFacture, string $referenceProduit, float $quantite)
    {
        $this->numeroFacture = $numeroFacture;
        $this->referenceProduit = $referenceProduit;
        $this->quantite = $quantite;
    }

    /**
     * @return string
     */
    public function getNumeroFacture(): string
    {
        return $this->numeroFacture;
    }

    /**
     * @return string
     */
    public function getReferenceProduit(): string
    {
        return $this->referenceProduit;
    }

    /**
     * @return float
     */
    public function getQuantite(): float
    {
        return $this->quantite;
    }
}
