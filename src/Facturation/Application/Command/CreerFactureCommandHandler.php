<?php

declare(strict_types=1);

namespace HM\Facturation\Application\Command;

use HM\Common\Application\Command\Command;
use HM\Common\Application\Command\CommandHandler;
use HM\Common\Application\Command\CommandResponse;
use HM\Common\Application\Command\EventStreamCommandResponse;
use HM\Common\Domain\Event\EventStream;
use HM\Facturation\Domain\FactureFactory;
use HM\Facturation\Domain\ClientView\ClientId;
use HM\Facturation\Domain\FactureRepository;
use HM\Facturation\Domain\Facture\Date;
use HM\Facturation\Domain\Facture\Reference;

class CreerFactureCommandHandler implements CommandHandler
{
    /**
     * @var FactureFactory
     */
    private $factureFactory;
    /**
     * @var FactureRepository
     */
    private $factureRepository;

    /**
     * @param FactureFactory $factureFactory
     * @param FactureRepository $factureRepository
     */
    public function __construct(FactureFactory $factureFactory, FactureRepository $factureRepository)
    {
        $this->factureFactory = $factureFactory;
        $this->factureRepository = $factureRepository;
    }

    /**
     * @param Command $command
     *
     * @return CommandResponse
     */
    public function handle(Command $command): CommandResponse
    {
        /** @var CreerFactureCommand $command */
        $facture = $this->factureFactory->creerFacture(
            ClientId::fromString($command->getClientId()),
            Reference::fromString($command->getReference()),
            Date::fromDateTime($command->getDate())
        );

        $this->factureRepository->add($facture);

        return EventStreamCommandResponse::withEventStream($facture->getUncommitedEvents());
    }
}
