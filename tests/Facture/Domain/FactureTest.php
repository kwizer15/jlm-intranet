<?php

declare(strict_types=1);

namespace Tests\HM\Facture\Domain;

use HM\Common\Domain\Event\EventMessage;
use HM\Facturation\Domain\ClientView;
use HM\Facturation\Domain\ClientView\ClientId;
use HM\Facturation\Domain\ClientViewRepository;
use HM\Facturation\Domain\DestinataireFactory;
use HM\Facturation\Domain\Event\FactureCreee;
use HM\Facturation\Domain\Facture\Date;
use HM\Facturation\Domain\Facture\Destinataire\AdressePostale;
use HM\Facturation\Domain\Facture\Destinataire\Nom;
use HM\Facturation\Domain\Facture\Destinataire\NumeroCompte;
use HM\Facturation\Domain\Facture\Reference;
use HM\Facturation\Domain\FactureFactory;
use HM\Facturation\Domain\FactureRepository;
use PHPUnit\Framework\TestCase;

class FactureTest extends TestCase
{
    public function testCreerFacture(): void
    {
        $factureRepository = $this->createMock(FactureRepository::class);
        $factureRepository->method('getNombrePourLAnnee')->willReturn(25);

        $clientRepository = $this->createMock(ClientViewRepository::class);
        $clientId = ClientId::generate();
        $clientRepository->method('get')->with($clientId)->willReturn(new ClientView(
            $clientId,
            Nom::fromString('John Doe'),
            NumeroCompte::fromString('411000'),
            AdressePostale::fromStrings('3 rue des Bois', '12345', 'Neverland')
        ));

        $factureFactory = new FactureFactory($factureRepository, new DestinataireFactory($clientRepository));

        $facture = $factureFactory->creerFacture(
            $clientId,
            Reference::fromString('Devis'),
            Date::fromDateTime(new \DateTimeImmutable('2019-02-10'))
        );
        $eventStream = $facture->getUncommitedEvents();

        $this->assertCount(1, $eventStream);

        /** @var EventMessage $message */
        $message = iterator_to_array($eventStream)[0];

        $this->assertEquals(0, $message->getPlayHead());

        /** @var FactureCreee $event */
        $event = $message->getPayload();
        $this->assertInstanceOf(FactureCreee::class, $event);
        $this->assertEquals('19020026', $event->getNumeroFacture());
        $this->assertEquals('2019-02-10', $event->getDate());
        $this->assertEquals('John Doe', $event->getClientNom());
        $this->assertEquals('411000', $event->getClientNumeroCompte());
        $this->assertEquals('3 rue des Bois', $event->getAdresseFacturationRue());
        $this->assertEquals('12345', $event->getAdresseCodePostal());
        $this->assertEquals('Neverland', $event->getAdresseVille());
        $this->assertEquals('Devis', $event->getReference());
    }
}
