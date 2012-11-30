<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\OfficeBundle\Entity\Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity(repositoryClass="JLM\OfficeBundle\Entity\QuoteRepository")
 */
class Quote extends Document
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
	 * Suiveur (pour le suivi)
	 * @var Collaborator $follower
	 * 
	 * @ORM\Column(name="follower",type="string", nullable=true)
	 */
	private $follower;
	
	/**
	 * Suiveur (pour le devis)
	 * @var string $followerCp
	 *
	 * @ORM\Column(name="follower_cp",type="string")
	 */
	private $followerCp;
	
	/**
	 * Porte concernée (pour le suivi)
	 * @var Door $door
	 * 
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
	 */
	private $door;
	
	/**
	 * Porte concernée (pour le devis)
	 * @var string $doorCp
	 *
	 * @ORM\Column(name="door_cp",type="text")
	 */
	private $doorCp;
	
	/**
	 * @var JLM\ModelBundle\Entity\SiteContact $contact
	 * 
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\SiteContact")
	 */
	private $contact;
	
	/**
	 * @var string $contactCp
	 * 
	 * @ORM\Column(name="contact_cp", type="string")
	 */
	private $contactCp;
	
	/**
	 * @var float $vat
	 * 
	 * @ORM\Column(name="vat",type="decimal",precision=3,scale=3)
	 */
	private $vat;
	
	/**
	 * @var float $vatTransmitter
	 *
	 * @ORM\Column(name="vat_transmitter",type="decimal",precision=3,scale=3)
	 */
	private $vatTransmitter;
	
	/**
	 * @var ArrayCollection $variants
	 * 
	 * @ORM\OneToMany(targetEntity="QuoteVariant",mappedBy="quote")
	 */
	private $variants;
	
	/**
	 * Construteur
	 *
	 */
	public function __construct()
	{
		$this->variants = new ArrayCollection;
	}
	
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
     * @param string $number
     * @return Quote
     */
    public function setNumber($number)
    {
    	$this->number = $number;
    	return $this;
    }
    
    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
    	return $this->number;
    }
    
    /**
     * Set follower
     *
     * @param string $follower
     * @return Quote
     */
    public function setFollower($follower)
    {
        $this->follower = $follower;
    
        return $this;
    }

    /**
     * Get follower
     *
     * @return string 
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Set followerCp
     *
     * @param string $followerCp
     * @return Quote
     */
    public function setFollowerCp($followerCp)
    {
        $this->followerCp = $followerCp;
    
        return $this;
    }

    /**
     * Get followerCp
     *
     * @return string 
     */
    public function getFollowerCp()
    {
        return $this->followerCp;
    }

    /**
     * Set doorCp
     *
     * @param string $doorCp
     * @return Quote
     */
    public function setDoorCp($doorCp)
    {
        $this->doorCp = $doorCp;
    
        return $this;
    }

    /**
     * Get doorCp
     *
     * @return string 
     */
    public function getDoorCp()
    {
        return $this->doorCp;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
    	foreach ($this->variants as $variant)
    		if ($variant->isValid())
    			return true;
    	return false;
    }
    
    /**
     * Is valid
     *
     * @return boolean
     */
    public function isValid()
    {
    	return $this->getValid();
    }
    
    /**
     * Get send
     *
     * @return boolean
     */
    public function getSend()
    {
    	foreach ($this->variants as $variant)
    		if ($variant->isSend())
    			return true;
    	return false;
    }
    
    /**
     * Is send
     *
     * @return boolean
     */
    public function isSend()
    {
    	return $this->getSend();
    }
    
    /**
     * Get given
     *
     * @return boolean 
     */
    public function getGiven()
    {
        foreach ($this->variants as $variant)
    		if ($variant->isGiven())
    			return true;
    	return false;
    }
    
    /**
     * Is given
     *
     * @return boolean
     */
    public function isGiven()
    {
    	return $this->getGiven();
    }

    /**
     * Set door
     *
     * @param JLM\ModelBundle\Entity\Door $door
     * @return Quote
     */
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
    {
        $this->door = $door;
    
        return $this;
    }

    /**
     * Get door
     *
     * @return JLM\ModelBundle\Entity\Door 
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Quote
     */
    public function setContact($contact)
    {
    	$this->contact = $contact;
    
    	return $this;
    }
    
    /**
     *
     * @return string
     */
    public function getContact()
    {
    	return $this->contact;
    }
    
    /**
     * Set contactCp
     *
     * @param string $contactCp
     * @return Quote
     */
    public function setContactCp($contactCp)
    {
    	$this->contactCp = $contactCp;
    
    	return $this;
    }
    
    /**
     * Get contactCp
     *
     * @return string
     */
    public function getContactCp()
    {
    	return $this->contactCp;
    }

    
    /**
     * Set vat
     *
     * @param float $vat
     * @return Quote
     */
    public function setVat($vat)
    {
    	$this->vat = $vat;
    
    	return $this;
    }
    
    /**
     * Get vat
     *
     * @return float
     */
    public function getVat()
    {
    	return $this->vat;
    }
    
    /**
     * Set vatTransmitter
     *
     * @param float $vatTransmitter
     * @return Quote
     */
    public function setVatTransmitter($vat)
    {
    	$this->vatTransmitter = $vat;
    
    	return $this;
    }
    
    /**
     * Get vatTransmitter
     *
     * @return float
     */
    public function getVatTransmitter()
    {
    	return $this->vatTransmitter;
    }
    
    /**
     * Add variant
     *
     * @param JLM\ModelBundle\Entity\QuoteVariant $variant
     * @return Quote
     */
    public function addVariant(\JLM\OfficeBundle\Entity\QuoteVariant $variant)
    {
    	$variant->setQuote($this);
    	$variant->setVariantNumber(sizeof($this->variants)+1);
    	$this->variants[] = $variant;
    		
    	return $this;
    }
    
    /**
     * Remove variant
     *
     * @param JLM\ModelBundle\Entity\QuoteVariant $variant
     */
    public function removeVariant(\JLM\OfficeBundle\Entity\QuoteVariant $variant)
    {
    	$variant->setQuote();
    	$this->variants->removeElement($variant);
    	$i = 0;
    	foreach ($this->variants as $v)
    		$v->setVariantNumber(++$i);
    }
    
    /**
     * Get variant
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getVariants()
    {
    	return $this->variants;
    }
}