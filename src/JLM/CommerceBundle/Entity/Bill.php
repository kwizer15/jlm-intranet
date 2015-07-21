<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CommerceBundle\Model\BillLineInterface;

use JLM\FeeBundle\Model\FeeInterface;
use JLM\FeeBundle\Model\FeesFollowerInterface;

use JLM\CommerceBundle\Model\BillSourceInterface;
use JLM\CommerceBundle\Model\BusinessInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Bill extends CommercialPart implements BillInterface
{
	/**
	 * @var int $id
	 */
	private $id;
	
	/**
	 * Pré label
	 * @var string
	 */
	private $prelabel;
	
	/**
	 * Reference
	 * @var string
	 */
	private $reference;
	
	/**
	 * Numéro de client
	 * @var string
	 */
	private $accountNumber;
	
	/**
	 * Details
	 * @var string $details
	 */
	private $details;
	
	/**
	 * Affaire concernée
	 * @var string $site
	 */
	private $site;
	
	/**
	 * Redevance
	 * @var Fee
	 */
	private $fee;
	
	/**
	 * Suivi de redevance
	 * @var FeesFollower
	 */
	private $feesFollower;
	
	/**
	 * Texte d'intro
	 * @var string $intro
	 */
	private $intro;
	
	/**
	 * Etat
	 * -1 = annulé
	 * 0 = en saisie
	 * 1 = envoyée
	 * 2 = réglée
	 * @var int $state
	 */
	private $state = 0;
	
	/**
	 * Clause de propriété
	 * @var string
	 */
	private $property;
	
	/**
	 * Escompte
	 * @var string
	 */
	private $earlyPayment;
	
	/**
	 * Pénalités
	 * @var string
	 */
	private $penalty;
	
	/**
	 * Échéance en jour
	 * @var int
	 */
	private $maturity;
	
	/**
	 * Lignes
	 * @var ArrayCollection
	 */
	private $lines;

	/**
	 * Remise générale
	 * @var float $discount
	 */
	private $discount = 0;
	
	/**
	 * Intervention (si suite à intervention)
	 * @var BillSourceInterface $intervention
	 */
	private $intervention;
	
	/**
	 * Date première relance
	 * @var \DateTime $firstBoost
	 */
	private $firstBoost;
	
	/**
	 * Date deuxième relance
	 * @var \DateTime $secondBoost
	 */
	private $secondBoost;
	
	/**
	 * Commentaire deuxième relance
	 * @var string $secondBoostComment
	 */
	private $secondBoostComment;

	/**
	 * 
	 * Affaire concernée (Objet)
	 * @var string $site
	 */
	private $siteObject;
	
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
     * {@inheritdoc}
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
     * @param int $maturity
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
     * @return int
     */
    public function getMaturity()
    {
        return $this->maturity;
    }
    
    /**
     * Get maturity date
     *
     * @return \DateTime
     */
    public function getMaturityDate()
    {
    	$date = clone $this->getCreation();
    	$date->add(new \DateInterval('P'.$this->getMaturity().'D'));
    	return $date;
    }

    /**
     * Set fee
     *
     * @param FeeInterface $fee
     * @return self
     */
    public function setFee(FeeInterface $fee = null)
    {
        $this->fee = $fee;
    
        return $this;
    }

    /**
     * Get fee
     *
     * @return FeeInterface
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set feesFollower
     *
     * @param FeesFollowerInterface $feesFollower
     * @return self
     */
    public function setFeesFollower(FeesFollowerInterface $feesFollower = null)
    {
        $this->feesFollower = $feesFollower;
    
        return $this;
    }

    /**
     * Get feesFollower
     *
     * @return FeesFollowerInterface
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
    	parent::__construct();
        $this->lines = new ArrayCollection;
    }
    
    /**
     * Set intro
     *
     * @param string $intro
     * @return self
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
     * @return self
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
     * @param BillLineInterface $line
     * @return self
     */
    public function addLine(BillLineInterface $line)
    {
    	$line->setPosition(sizeof($this->lines));
    	$line->setBill($this);
        $this->lines[] = $line;
    
        return $this;
    }

    /**
     * Remove lines
     *
     * @param BillLineInterface $line
     */
    public function removeLine(BillLineInterface $line)
    {
    	$line->setBill(null);
        $this->lines->removeElement($line);
        
        return $this;
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
     * @return self
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
    
    /**
     * Get Total HT
     * @return float
     */
    public function getTotalPrice()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    	{
    	    $total += $line->getPrice();
    	}
    	$total *= (1-$this->getDiscount());
    	
    	return $total;
    }
    
    /**
     * Get Total TVA
     * @return float
     */
    public function getTotalVat()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    	{
    		$total += $line->getVatValue();
    	}
    	$total *= (1-$this->getDiscount());
    	
    	return $total;
    }
    
    /**
     * Get Total TVA par taux
     * @return float
     */
    public function getTotalVatByRate()
    {
    	$total = array();
    	foreach ($this->getLines() as $line)
    	{
    		$index = ''.($line->getVat()*100);
    		if (!isset($total[$index]))
    		{
    			$total[$index] = array('vat'=>0,'base'=>0);
    		}
    		$total[$index]['vat'] += $line->getVatValue();
    		$total[$index]['base'] += $line->getPrice();
    	}
    	foreach ($total as $key=>$tot)
    	{
    		$total[$key]['vat'] *= (1-$this->getDiscount());
    	}
    		
    	return $total;
    }
    
    /**
     * Get Total TTC
     * @return float
     */
    public function getTotalPriceAti()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    	{
    		$total += $line->getPriceAti();
    	}
    	$total *= (1-$this->getDiscount());
    	
    	return $total;
    }
    
    /**
     * Vérifie les sources
     * @return bool
     */
    public function isOneSource()
    {
    	return !(($this->fee !== null) && ($this->getSource() !== null));
    }

    /**
     * Set source
     *
     * @param BillSourceInterface $source
     * @return self
     */
    public function setSource(BillSourceInterface $source = null)
    {
        $this->intervention = $source;
    
        return $this;
    }
    
    /**
     * Get intervention
     *
     * @return BillSourceInterface
     */
    public function getSource()
    {
        return $this->intervention;
    }
    
    /**
     * Set intervention
     *
     * @param BillSourceInterface $intervention
     * @return self
     * @deprecated Use setSource($source)
     */
    public function setIntervention(BillSourceInterface $intervention = null)
    {
        return $this->setSource($intervention);
    }

    /**
     * Get intervention
     *
     * @return BillSourceInterface
     * @deprecated Use getSource
     */
    public function getIntervention()
    {
        return $this->getSource();
    }

    /**
     * Set firstBoost
     *
     * @param \DateTime $firstBoost
     * @return self
     */
    public function setFirstBoost(\DateTime $firstBoost = null)
    {
        $this->firstBoost = $firstBoost;
    
        return $this;
    }

    /**
     * Get firstBoost
     *
     * @return \DateTime 
     */
    public function getFirstBoost()
    {
        return $this->firstBoost;
    }

    /**
     * Set secondBoost
     *
     * @param \DateTime $secondBoost
     * @return self
     */
    public function setSecondBoost(\DateTime $secondBoost = null)
    {
        $this->secondBoost = $secondBoost;
    
        return $this;
    }

    /**
     * Get secondBoost
     *
     * @return \DateTime 
     */
    public function getSecondBoost()
    {
        return $this->secondBoost;
    }

    /**
     * Set secondBoostComment
     *
     * @param string $secondBoostComment
     * @return self
     */
    public function setSecondBoostComment($secondBoostComment)
    {
        $this->secondBoostComment = $secondBoostComment;
    
        return $this;
    }

    /**
     * Get secondBoostComment
     *
     * @return string 
     */
    public function getSecondBoostComment()
    {
        return $this->secondBoostComment;
    }

    /**
     * {@inheritdoc}
     */
    public function setSiteObject(BusinessInterface $siteObject = null)
    {
        $this->siteObject = $siteObject;
    
        return $this;
    }

    /**
     * Get siteObject
     *
     * @return BusinessInterface
     * @deprecated Use getBusiness()
     */
    public function getSiteObject()
    {
        return $this->siteObject;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setBusiness(BusinessInterface $business = null)
    {
        $this->business = $business;
    
        return $this;
    }
    
    /**
     * Get siteObject
     *
     * @return BusinessInterface
     */
    public function getBusiness()
    {
        return $this->business;
    }
    
    /**
     * Is to boost
     * 
     * @return bool
     */
    public function isToBoost()
    {
    	$today = new \DateTime;
    	if ($this->getState() == 1)
    	{
    		if ($this->getMaturityDate() < $today && $this->getFirstBoost() === null)
    		{
    			return true;
    		}
    		if ($this->getFirstBoost() !== null)
    		{
	    		$date = clone $this->getFirstBoost();
	    		$date->add(new \DateInterval('P'.$this->getMaturity().'D'));
	    		if ($date < $today && $this->getSecondBoost() === null)
	    		{
	    			return true;
	    		}
    		}
    	}
    	
    	return false;
    }
    
    public function getSrc()
    {
    	if ($this->intervention !== null)
    	{
    		return $this->intervention->getDoor();
    	}
    	if ($this->fee !== null)
    	{
    		return $this->fee;
    	}
    	
    	return null;
    }
    
	public function getManagerContacts()
    {
    	$src = $this->getSrc();
    	if ($src === null)
    	{
    		return array();
    	}
    	
    	return $this->_createContactFromEmail($this->getSrc()->getManagerEmails());
    }
    
    public function getBoostContacts()
    {
    	$src = $this->getSrc();
    	if ($src === null)
    	{
    		return array();
    	}
    	
    	return $this->_createContactFromEmail($this->getSrc()->getAccountingEmails());
    }
    
    private function _createContactFromEmail($emails)
    {
    	$c = array();
    	if ($emails === null)
    	{
    		return $c;
    	}
    
    	foreach ($emails as $email)
    	{
    		$temp = new Company();
    		$temp->setEmail($email);
    		$c[] = $temp;
    	}
    
    	return $c;
    }
}