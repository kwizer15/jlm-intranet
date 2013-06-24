<?php

namespace JLM\OfficeBundle\Entity;

use JLM\OfficeBundle\Entity\Ask;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JLM\ModelBundle\Entity\Door;
use JLM\OfficeBundle\Entity\Quote;
use JLM\DailyBundle\Entity\Intervention;

/**
 * Demande de devis
 * JLM\OfficeBundle\Entity\AskQuote
 *
 * @ORM\Table(name="askquote")
 * @ORM\Entity
 */
class AskQuote extends Ask
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Suite à intervention
	 * @ORM\OneToOne(targetEntity="JLM\DailyBundle\Entity\Intervention", inversedBy="askQuote")
	 */
	private $intervention;
	
	/**
	 * Intallation
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
	 */
	private $door;
	
	/**
	 * Résumé de la demande
	 * @ORM\Column(name="ask",type="text")
	 * @Assert\NotBlank()
	 */
	private $ask;
	
	/**
	 * Devis
	 * @ORM\OneToMany(targetEntity="Quote",mappedBy="ask")
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
     * Set ask
     *
     * @param string $ask
     * @return AskQuote
     */
    public function setAsk($ask)
    {
        $this->ask = $ask;
    
        return $this;
    }

    /**
     * Get ask
     *
     * @return string 
     */
    public function getAsk()
    {
        return $this->ask;
    }

    /**
     * Set intervention
     *
     * @param \JLM\DailyBundle\Entity\Intervention $intervention
     * @return AskQuote
     */
    public function setIntervention(\JLM\DailyBundle\Entity\Intervention $intervention = null)
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
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
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
    	if ($this->getIntervention() !== null)
    		return $this->getIntervention()->getDoor();
        return $this->door;
    }
    
    /**
     * Get Site
     */
    public function getSite()
    {
    	if ($this->getDoor() !== null)
    		return $this->getDoor()->getSite();
    	return parent::getSite();
    }
    
    /**
     * Get Trustee
     */
    public function getTrustee()
    {
    	if ($this->getDoor() !== null)
    		return $this->getDoor()->getTrustee();
    	return parent::getTrustee();
    }
    
    /**
     * Get method
     */
    public function getMethod()
    {
    	if ($this->getIntervention() !== null)
    		return null;
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
     * @param \JLM\OfficeBundle\Entity\Quote $quotes
     * @return AskQuote
     */
    public function addQuote(\JLM\OfficeBundle\Entity\Quote $quotes)
    {
        $this->quotes[] = $quotes;
    
        return $this;
    }

    /**
     * Remove quotes
     *
     * @param \JLM\OfficeBundle\Entity\Quote $quotes
     */
    public function removeQuote(\JLM\OfficeBundle\Entity\Quote $quotes)
    {
        $this->quotes->removeElement($quotes);
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