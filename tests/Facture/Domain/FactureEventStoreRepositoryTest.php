<?php

declare(strict_types=1);

namespace Tests\HM\Facture\Domain;

use HM\Common\Domain\EventSourcing\FileEventStore;
use HM\Common\Domain\EventSourcing\InMemoryEventStore;
use HM\Common\Domain\Serializer\ReflectionSerializer;
use HM\Facturation\Domain\ClientView\ClientId;
use HM\Facturation\Domain\Facture;
use HM\Facturation\Domain\Facture\NumeroFacture;
use HM\Facturation\Domain\FactureEventStoreRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FactureEventStoreRepositoryTest extends TestCase
{
    /**
     * @var FactureEventStoreRepository
     */
    private $repository;

    public function testGetExistingFacture(): void
    {
        $serializer = new ReflectionSerializer();
        $eventStore = new FileEventStore(__DIR__.'/Fixtures/factures.eventsource', $serializer);
        $this->repository = new FactureEventStoreRepository($eventStore);

        $facture = $this->repository->get(NumeroFacture::fromString('19020002'));

        $this->assertEquals('19020002', $facture->getAggregateRootId()->toString());
    }

    public function testGetNotExistentFacture(): void
    {
        $serializer = new ReflectionSerializer();
        $eventStore = new FileEventStore(__DIR__.'/Fixtures/factures.eventsource', $serializer);
        $this->repository = new FactureEventStoreRepository($eventStore);

        $this->expectException(\DomainException::class);

        $this->repository->get(NumeroFacture::fromString('18020002'));
    }

    public function testAjouteNouvelleFacture(): void
    {
        $eventStore = new InMemoryEventStore();
        $this->repository = new FactureEventStoreRepository($eventStore);

        $facture = Facture::etablirFacture(
            NumeroFacture::fromString('18020002'),
            Facture\Date::aujourdHui(),
            Facture\Destinataire::withDestinataire(
                ClientId::fromString(Uuid::uuid4()->toString()),
                Facture\Destinataire\Nom::fromString('Dupond Michel'),
                Facture\Destinataire\NumeroCompte::fromString('411000'),
                Facture\Destinataire\AdressePostale::fromStrings('3 rue des Maronniers', '75001', 'PARIS')
            ),
            Facture\Reference::fromString('devis 125'),
            Facture\ReglesPaiement::withRegles(
                Facture\ReglesPaiement\Echeance::fromJours(3),
                Facture\ReglesPaiement\Escompte::fromFloat(1.2, 1),
                Facture\ReglesPaiement\PenaliteRetard::fromFloat(1.5, 1)
            ),
            Facture\TVA::normale()
        );

        $this->repository->add($facture);

        // No exception
        $facture2 = $this->repository->get(NumeroFacture::fromString('18020002'));

        $this->assertEquals($facture, $facture2);
    }
}
