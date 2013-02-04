<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\OfficeBundle\Entity\Bill
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity
 */
class Bill extends Document
{
	/**
	 * @var int $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Numéro du devis
	 * @ORM\Column(name="number", type="integer")
	 */
	private $number;
	
	/**
	 * Pré label
	 * @ORM\Column(name="prelabel", type="text")
	 */
	private $prelabel;
	
	/**
	 * Reference
	 * @var string
	 * 
	 * @ORM\Column(name="reference",type="text")
	 */
	private $reference;
	
	/**
	 * Numéro de client
	 * @var string
	 * 
	 * @ORM\Column(name="accountNumber",type="string")
	 */
	private $accountNumber;
	
	/**
	 * Details
	 * @var string $details
	 *
	 * @ORM\Column(name="details",type="text")
	 */
	private $details;
	
	/**
	 * Affaire concernée
	 * @var string $site
	 *
	 * @ORM\Column(name="door_cp",type="text")
	 */
	private $site;
	
	/**
	 * Redevance
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Fee")
	 */
	private $fee;
	
	/**
	 * Suivi de redevance
	 * @ORM\ManyToOne(targetEntity="FeesFollower")
	 */
	private $feesFollower;
	
	/**
	 * Texte d'intro
	 * @var string $intro
	 *
	 * @ORM\Column(name="intro",type="text")
	 */
	private $intro;
	
	/**
	 * Etat
	 * -1 = annulé
	 * 0 = en saisie
	 * 1 = près à envoyer
	 * 2 = imprimer
	 * 3 = envoyé (en attente de l'accusé)
	 * 4 = envoyé (accusé reçu)
	 * 5 = accordé
	 * @var int $state
	 *
	 * @ORM\Column(name="state",type="smallint")
	 */
	private $state = 0;
	
	/**
	 * Clause de propriété
	 * @ORM\Column(name="property",type="string", nullable=true)
	 */
	private $property;
	
	/**
	 * Escompte
	 * @ORM\Column(name="earlyPayment",type="string")
	 */
	private $earlyPayment;
	
	/**
	 * Pénalités
	 * @ORM\Column(name="penalty",type="string")
	 */
	private $penalty;
	
	/**
	 * Maturity
	 * @ORM\Column(name="maturity",type="date")
	 */
	private $maturity;
	
	/**
	 * Lignes
	 * @ORM\OneToMany(targetEntity="BillLine", mappedBy="bill")
	 */
	private $lines;

	/**
	 * Remise générale
	 * @var float $discount
	 *
	 * @ORM\Column(name="discount", type="decimal", scale=7)
	 */
	private $discount = 0;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Bill
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set prelabel
     *
     * @param string $prelabel
     * @return Bill
     */
    public function setPrelabel($prelabel)
    {
        $this->prelabel = $prelabel;
    
        return $this;
    }

    /**
     * Get prelabel
     *
     * @return string 
     */
    public function getPrelabel()
    {
        return $this->prelabel;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Bill
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     * @return Bill
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    
        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string 
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return Bill
     */
    public function setDetails($details)
    {
        $this->details = $details;
    
        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Bill
     */
    public function setSite($site)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set property
     *
     * @param string $property
     * @return Bill
     */
    public function setProperty($property)
    {
        $this->property = $property;
    
        return $this;
    }

    /**
     * Get property
     *
     * @return string 
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set earlyPayment
     *
     * @param string $earlyPayment
     * @return Bill
     */
    public function setEarlyPayment($earlyPayment)
    {
        $this->earlyPayment = $earlyPayment;
    
        return $this;
    }

    /**
     * Get earlyPayment
     *
     * @return string 
     */
    public function getEarlyPayment()
    {
        return $this->earlyPayment;
    }

    /**
     * Set penalty
     *
     * @param string $penalty
     * @return Bill
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
    
        return $this;
    }

    /**
     * Get penalty
     *
     * @return string 
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * Set maturity
     *
     * @param \DateTime $maturity
     * @return Bill
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
     * Set fee
     *
     * @param JLM\ModelBundle\Entity\Fee $fee
     * @return Bill
     */
    public function setFee(\JLM\ModelBundle\Entity\Fee $fee = null)
    {
        $this->fee = $fee;
    
        return $this;
    }

    /**
     * Get fee
     *
     * @return JLM\ModelBundle\Entity\Fee 
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set feesFollower
     *
     * @param JLM\OfficeBundle\Entity\FeesFollower $feesFollower
     * @return Bill
     */
    public function setFeesFollower(\JLM\OfficeBundle\Entity\FeesFollower $feesFollower = null)
    {
        $this->feesFollower = $feesFollower;
    
        return $this;
    }

    /**
     * Get feesFollower
     *
     * @return JLM\OfficeBundle\Entity\FeesFollower 
     */
    public function getFeesFollower()
    {
        return $this->feesFollower;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lines = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set intro
     *
     * @param string $intro
     * @return Bill
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
    
        return $this;
    }

    /**
     * Get intro
     *
     * @return string 
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Bill
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add lines
     *
     * @param JLM\OfficeBundle\Entity\BillLine $lines
     * @return Bill
     */
    public function addLine(\JLM\OfficeBundle\Entity\BillLine $lines)
    {
        $this->lines[] = $lines;
    
        return $this;
    }

    /**
     * Remove lines
     *
     * @param JLM\OfficeBundle\Entity\BillLine $lines
     */
    public function removeLine(\JLM\OfficeBundle\Entity\BillLine $lines)
    {
        $this->lines->removeElement($lines);
    }

    /**
     * Get lines
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLines()
    {
        return $this->lines;
    }
    
    /**
     * Set discount
     *
     * @param float $discount
     * @return Document
     */
    public function setDiscount($discount)
    {
    	$this->discount = $discount;
    
    	return $this;
    }
    
    /**
     * Get discount
     *
     * @return float
     */
    public function getDiscount()
    {
    	return $this->discount;
    }
}