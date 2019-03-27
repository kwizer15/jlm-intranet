<?php

declare(strict_types=1);

namespace HM\Facturation\Application\Command;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandHandler;
use HM\Common\Application\Command\CommandResponse;
use HM\Common\Application\Command\EventStreamCommandResponse;
use HM\Facturation\Domain\Facture\NumeroFacture;
use HM\Facturation\Domain\FactureRepository;

class AjouterLigneFactureCommandHandler implements CommandHandler
{
    private $factureRepository;

    public function __construct(FactureRepository $factureRepository)
    {
        $this->factureRepository = $factureRepository;
    }

    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function handle(Command $command): CommandResponse
    {
        $produit = $this->produitViewRepository->

        /** @var AjouterLigneFactureCommand $command */
        $facture = $this->factureRepository->get(NumeroFacture::fromString($command->getNumeroFacture()));

        $facture->ajouteLigne();
        return EventStreamCommandResponse::withEventStream($facture->getUncommitedEvents());
    }
}
