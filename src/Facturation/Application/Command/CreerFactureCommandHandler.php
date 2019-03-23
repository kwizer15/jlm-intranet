<?php

declare(strict_types=1);

namespace HM\Facturation\Application\Command;

use HM\Common\Application\Command;
use HM\Common\Application\CommandHandler;
use HM\Common\Domain\Event\EventStream;
use HM\Facturation\Domain\Factory\FactureFactory;
use HM\Facturation\Domain\Identifier\ClientId;
use HM\Facturation\Domain\Repository\FactureRepository;
use HM\Facturation\Domain\ValueType\Date;
use HM\Facturation\Domain\ValueType\Reference;

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
     * @return EventStream
     */
    public function handle(Command $command): EventStream
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
