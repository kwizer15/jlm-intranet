<?php

namespace JLM\OfficeBundle\Entity;

use JLM\AskBundle\Entity\Ask;
use JLM\AskBundle\Model\CommunicationMeansInterface;
use JLM\AskBundle\Model\PayerInterface;
use JLM\AskBundle\Model\SubjectInterface;
use JLM\ModelBundle\Entity\Door;
use JLM\CommerceBundle\Model\QuoteInterface;
use JLM\DailyBundle\Entity\Intervention;

class AskQuote extends Ask
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * Suite à intervention
     *
     * @var Intervention
     */
    private $intervention;
    
    /**
     * Intallation
     *
     * @var Door
     */
    private $door;
    
    /**
     * Devis
     *
     * @var QuoteInterface[]
     */
    private $quotes;

    public function __construct()
    {
        $this->quotes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get Id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    protected function getUploadDir(): string
    {
        return 'uploads/documents/askquote';
    }

    /**
     * Set intervention
     *
     * @param \JLM\DailyBundle\Entity\Intervention|null $intervention
     *
     * @return AskQuote
     */
    public function setIntervention(?Intervention $intervention = null): self
    {
        $this->intervention = $intervention;
        $this->setDoor();
        
        return $this;
    }

    /**
     * Get intervention
     *
     * @return Intervention|null
     */
    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    /**
     * Set door
     *
     * @param Door|null $door
     *
     * @return AskQuote
     */
    public function setDoor(?Door $door = null): self
    {
        $this->door = $door;
        $this->setSubject();
        $this->setPayer();
        
        return $this;
    }

    /**
     * @return Door
     */
    public function getDoor(): Door
    {
        if ($this->getIntervention() !== null) {
            return $this->getIntervention()->getDoor();
        }
        
        return $this->door;
    }

    /**
     * @return SubjectInterface
     */
    public function getSite(): SubjectInterface
    {
        if ($this->getDoor() !== null) {
            return $this->getDoor()->getSite();
        }
        
        return $this->getSubject();
    }

    /**
     * @return PayerInterface
     */
    public function getTrustee(): PayerInterface
    {
        if ($this->getDoor() !== null) {
            return $this->getDoor()->getTrustee();
        }

        return $this->getPayer();
    }

    /**
     * @return CommunicationMeansInterface|null
     */
    public function getMethod(): ?CommunicationMeansInterface
    {
        if ($this->getIntervention() !== null) {
            return null;
        }

        return parent::getMethod();
    }
    
    /**
     * Add quotes
     *
     * @param QuoteInterface $quote
     *
     * @return bool
     */
    public function addQuote(QuoteInterface $quote): bool
    {
        $this->quotes[] = $quote;
    
        return true;
    }

    /**
     * Remove quotes
     *
     * @param QuoteInterface $quote
     *
     * @return bool
     */
    public function removeQuote(QuoteInterface $quote): bool
    {
        return $this->quotes->removeElement($quote);
    }

    /**
     * Get quotes
     *
     * @return QuoteInterface[]
     */
    public function getQuotes(): iterable
    {
        return $this->quotes;
    }

    /**
     * Populate from intervention
     *
     * @param Intervention $intervention
     *
     * @return void
     *
     * @throws \Exception
     */
    public function populateFromIntervention(Intervention $intervention): void
    {
        $this->setCreation(new \DateTime);
        $maturity = new \DateTime;
        $maturity->add(new \DateInterval('P15D'));
        $this->setMaturity($maturity);
        $this->setIntervention($intervention);
        $this->setAsk($intervention->getRest());
    }
}
