<?php

declare(strict_types=1);

namespace HM\Application\Facturation\Command;

use HM\Application\Common\Command\Command;
use HM\Application\Common\Command\CommandHandler;
use HM\Domain\Common\DomainEvent\DomainEventStream;
use HM\Domain\Facturation\Factory\FactureFactory;
use HM\Domain\Facturation\Identities\ClientId;
use HM\Domain\Facturation\Repository\FactureRepository;
use HM\Domain\Facturation\ValueType\Date;
use HM\Domain\Facturation\ValueType\Reference;

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
     */
    public function __construct(FactureFactory $factureFactory, FactureRepository $factureRepository)
    {
        $this->factureFactory = $factureFactory;
        $this->factureRepository = $factureRepository;
    }

    /**
     * @param Command $command
     *
     * @return DomainEventStream
     */
    public function handle(Command $command): DomainEventStream
    {
        /** @var CreerFactureCommand $command */
        $facture = $this->factureFactory->creerFacture(
            ClientId::fromString($command->getClientId()),
            Reference::fromString($command->getReference()),
            Date::fromDateTime($command->getDate())
        );

        $this->factureRepository->add($facture);

        return $facture->getUncommitedEvents();
    }

    /**
     * @return string
     */
    public static function listenTo(): string
    {
        return CreerFactureCommand::class;
    }
}
