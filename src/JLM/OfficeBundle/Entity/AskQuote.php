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
	 * @ORM\ManyToOne(targetEntity="JLM\DailyBundle\Entity\Intervention")
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
    
        return $this;
    }

    /**
     * Get door
     *
     */
    public function getDoor()
    {
        return $this->door;
    }
    
    /**
     * Vérifie si l'installation se situe bien sur l'affaire
     * @Assert\True(message = "L'installation ne se situe pas sur cette affaire")
     */
    public function isDoorOnSite()
    {
    	$door = $this->getDoor();
    	if ($door === null)
    		return true;
    	return $door->getSite()->getId() === $this->getSite()->getId();
    }
    
    /**
     * Vérifie si l'intervention à bien eu lieu sur le site
     * @Assert\True(message = "L'intervention n'a pas été effectué sur cette affaire")
     */
    public function isInterventionOnSite()
    {
    	if ($this->intervention === null)
    		return true;
    	$door = $this->intervention->getDoor();
    	if ($door === null)
    		return true;
    	$site = $this->getSite();
    	if ($site === null)
    		return false;
    	return $door->getSite()->getId() == $site->getId();
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
}