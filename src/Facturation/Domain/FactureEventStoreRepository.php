<?php

declare(strict_types=1);

namespace HM\Facturation\Domain;

use HM\Common\Domain\Event\EventMessage;
use HM\Common\Domain\EventSourcing\EventStore;
use HM\Facturation\Domain\Event\FactureEtablie;
use HM\Facturation\Domain\Facture\Date;
use HM\Facturation\Domain\Facture\NumeroFacture;

class FactureEventStoreRepository implements FactureRepository
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * @param int $annee
     *
     * @return int
     */
    public function getNombrePourLAnnee(int $annee): int
    {
        $eventStream = $this->eventStore->load(Facture::class);
        $count = 0;
        /** @var EventMessage $eventMessage */
        foreach ($eventStream as $eventMessage) {
            $payload = $eventMessage->getPayload();
            if (!$payload instanceof FactureEtablie) {
                continue;
            }
            if ($annee !== Date::fromString($payload->getDate())->getAnnee()) {
                continue;
            }
            ++$count;
        }

        return $count;
    }

    /**
     * @param Facture $facture
     *
     * @return void
     */
    public function add(Facture $facture): void
    {
        $this->eventStore->append($facture->getUncommitedEvents());
    }

    /**
     * @param NumeroFacture $numeroFacture
     *
     * @return Facture
     *
     * @throws \DomainException
     * @throws \Exception
     */
    public function get(NumeroFacture $numeroFacture): Facture
    {
        $eventStream = $this->eventStore->load(Facture::class, $numeroFacture->toString());

        return Facture::reconstitute($eventStream);
    }
}
