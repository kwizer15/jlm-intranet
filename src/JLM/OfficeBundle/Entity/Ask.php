<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JLM\ModelBundle\Entity\UploadDocument;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Person;
use JLM\OfficeBundle\Entity\AskMethod;

/**
 * JLM\OfficeBundle\Entity\Ask
 *
 * @ORM\MappedSuperclass
 */
abstract class Ask extends UploadDocument
{
	/**
	 * Syndic
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Trustee")
	 */
	private $trustee;
	
	/**
	 * Affaire
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Site")
	 */
	private $site;
	
	/**
	 * Méthode de la demande
	 * @ORM\ManyToOne(targetEntity="AskMethod")
	 */
	private $method;
	
	/**
	 * Date de la demande
	 * @ORM\Column(name="creation",type="date")
	 * @Assert\Date()
	 * @Assert\NotNull()
	 */
	private $creation;
	
	/**
	 * Date d'échéance
	 * @ORM\Column(name="maturity",type="date", nullable=true)
	 * @Assert\Date()
	 */
	private $maturity;
	
	/**
	 * Contact
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Person")
	 * @Assert\Valid
	 */
	private $person;

	/**
	 * Ne pas traiter
	 * @ORM\Column(name="dont_treat", type="text", nullable=true)
	 */
	private $dontTreat;

	/**
	 * Résumé de la demande
	 * @ORM\Column(name="ask",type="text")
	 * @Assert\NotBlank()
	 */
	private $ask;
	
    /**
     * Set creation
     *
     * @param \DateTime $creation
     * @return Ask
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;
    
        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime 
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set maturity
     *
     * @param \DateTime $maturity
     * @return Ask
     */
    public function setMaturity($maturity)
    {
        $this->maturity = $maturity;
    
        return $this;
    }

    /**
     * Get maturity
     *
     * @return \DateTime 
     */
    public function getMaturity()
    {
        return $this->maturity;
    }

    /**
     * Set trustee
     *
     * @param \JLM\ModelBundle\Entity\Trustee $trustee
     * @return Ask
     */
    public function setTrustee(\JLM\ModelBundle\Entity\Trustee $trustee = null)
    {
        $this->trustee = $trustee;
    
        return $this;
    }

    /**
     * Get trustee
     *
     * @return \JLM\ModelBundle\Entity\Trustee 
     */
    public function getTrustee()
    {
        return $this->trustee;
    }

    /**
     * Set site
     *
     * @param \JLM\ModelBundle\Entity\Site $site
     * @return Ask
     */
    public function setSite(\JLM\ModelBundle\Entity\Site $site = null)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return \JLM\ModelBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set method
     *
     * @param \JLM\OfficeBundle\Entity\AskMethod $method
     * @return Ask
     */
    public function setMethod(\JLM\OfficeBundle\Entity\AskMethod $method = null)
    {
        $this->method = $method;
    
        return $this;
    }

    /**
     * Get method
     *
     * @return \JLM\OfficeBundle\Entity\AskMethod 
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set person
     *
     * @param \JLM\ModelBundle\Entity\Person $person
     * @return Ask
     */
    public function setPerson(\JLM\ModelBundle\Entity\Person $person = null)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return \JLM\ModelBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }
    
    /**
     * Vérifie si l'échéance est correct
     * @Assert\True(message = "La date d'échéance doit être ultérieure à la date de la demande")
     */
    public function isCreationBeforeMaturity()
    {
    	return $this->creation <= $this->maturity || $this->maturity === null;
    }
    
    /**
     * Get dontTreat
     * @return string|null
     */
    public function setDontTreat($dontTreat = null)
    {
    	$this->dontTreat = $dontTreat;
    	return $this;
    }
    
    /**
     * Get dontTreat
     * @return string|null
     */
    public function getDontTreat()
    {
    	return $this->dontTreat;
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
}