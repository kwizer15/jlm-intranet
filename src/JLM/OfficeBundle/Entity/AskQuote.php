<?php

namespace JLM\OfficeBundle\Entity;

use JLM\AskBundle\Entity\Ask;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JLM\ModelBundle\Entity\Door;
use JLM\CommerceBundle\Model\QuoteInterface;
use JLM\DailyBundle\Entity\Intervention;

/**
 * Demande de devis
 * JLM\OfficeBundle\Entity\AskQuote
 */
class AskQuote extends Ask
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * Suite à intervention
     * @var Intervention
     */
    private $intervention;
    
    /**
     * Intallation
     * @var Door
     */
    private $door;
    
    /**
     * Devis
     * @var QuoteInterface[]
     */
    private $quotes;
    
    /**
     * Get Id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Dossier de stockage des documents uploadés
     */
    protected function getUploadDir()
    {
        return 'uploads/documents/askquote';
    }

    /**
     * Set intervention
     *
     * @param \JLM\DailyBundle\Entity\Intervention $intervention
     * @return AskQuote
     */
    public function setIntervention(Intervention $intervention = null)
    {
        $this->intervention = $intervention;
        $this->setDoor(null);
        
        return $this;
    }

    /**
     * Get intervention
     *
     * @return \JLM\DailyBundle\Entity\Intervention
     */
    public function getIntervention()
    {
        return $this->intervention;
    }

    /**
     * Set door
     *
     * @param \JLM\ModelBundle\Entity\Door $door
     * @return AskQuote
     */
    public function setDoor(Door $door = null)
    {
        $this->door = $door;
        $this->site = null;
        $this->trustee = null;
        
        return $this;
    }

    /**
     * Get door
     *
     */
    public function getDoor()
    {
        if ($this->getIntervention() !== null) {
            return $this->getIntervention()->getDoor();
        }
        
        return $this->door;
    }
    
    /**
     * Get Site
     */
    public function getSite()
    {
        if ($this->getDoor() !== null) {
            return $this->getDoor()->getSite();
        }
        
        return parent::getSubject();
    }
    
    /**
     * Get Trustee
     */
    public function getTrustee()
    {
        if ($this->getDoor() !== null) {
            return $this->getDoor()->getTrustee();
        }
        return parent::getPayer();
    }
    
    /**
     * Get method
     */
    public function getMethod()
    {
        if ($this->getIntervention() !== null) {
            return null;
        }
        return parent::getMethod();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add quotes
     *
     * @param QuoteInterface $quotes
     * @return bool
     */
    public function addQuote(QuoteInterface $quotes)
    {
        $this->quotes[] = $quotes;
    
        return true;
    }

    /**
     * Remove quotes
     *
     * @param QuoteInterface $quotes
     * @return bool
     */
    public function removeQuote(QuoteInterface $quotes)
    {
        return $this->quotes->removeElement($quotes);
    }

    /**
     * Get quotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotes()
    {
        return $this->quotes;
    }
    
    /**
     * Populate from intervention
     *
     * @param Intervention $interv
     * @return void
     */
    public function populateFromIntervention(Intervention $interv)
    {
        $this->setCreation(new \DateTime);
        $maturity = new \DateTime;
        $maturity->add(new \DateInterval('P15D'));
        $this->setMaturity($maturity);
        $this->setIntervention($interv);
        $this->setAsk($interv->getRest());
    }
}
