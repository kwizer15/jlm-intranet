<?php

declare(strict_types=1);

namespace HM\Facturation\Application\Command;

use HM\Common\Application\Command;

class CreerFactureCommand implements Command
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @param string $clientId
     * @param string $reference
     * @param \DateTimeImmutable $date
     */
    public function __construct(string $clientId, string $reference, \DateTimeImmutable $date)
    {

        $this->clientId = $clientId;
        $this->reference = $reference;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
