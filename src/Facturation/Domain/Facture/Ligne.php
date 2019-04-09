<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture;

use HM\Common\Domain\Entity\EntityId;
use HM\Common\Domain\EventSourcing\EventSourcedEntity;
use HM\Facturation\Domain\Event\LigneAjoutee;
use HM\Facturation\Domain\Facture\Ligne\LigneId;

final class Ligne extends EventSourcedEntity
{
    /**
     * @var LigneId
     */
    private $id;

    /**
     * @return EntityId
     */
    public function getEntityId(): EntityId
    {
        return $this->id;
    }

    protected function whenLigneAjoutee(LigneAjoutee $event): void
    {
        if (null !== $this->id) {
            throw new \DomainException('Cette ligne à déjà été ajoutée.');
        }

        $this->id = LigneId::fromString($event->getLigneId());
    }
}
