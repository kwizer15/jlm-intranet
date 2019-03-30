<?php

declare(strict_types=1);

namespace Tests\HM\Facture\Domain\Fixtures;

use HM\Common\Domain\EventSourcing\FileEventStore;
use HM\Common\Domain\Serializer\ReflectionSerializer;
use HM\Facturation\Domain\Facture;
use HM\Facturation\Domain\Facture\NumeroFacture;
use HM\Facturation\Domain\FactureEventStoreRepository;

class FactureFixtures
{
    public static function withId(string $id): Facture
    {
        $eventStore = new FileEventStore('factures.es', new ReflectionSerializer());
        $repository = new FactureEventStoreRepository($eventStore);
        return $repository->get(NumeroFacture::fromString($id));
    }
}
