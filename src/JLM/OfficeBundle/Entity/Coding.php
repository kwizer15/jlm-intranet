<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\OfficeBundle\Entity\Coding
 *
 * @ORM\Table(name="codings")
 * @ORM\Entity(repositoryClass="JLM\OfficeBundle\Entity\CodingRepository")
 */
class Coding extends Document
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
	 * Devis lié
	 * @ORM\OneToOne(targetEntity="Quote")
	 */
	private $quote;
	
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
	 * Lignes
	 * @var ArrayCollection $lines
	 * 
	 * @ORM\OneToMany(targetEntity="CodingLine",mappedBy="coding")
	 * @ORM\OrderBy({"position" = "ASC"})
	 */
	private $lines;
	
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
	 * Construteur
	 * 
	 */
	public function __construct()
	{
		$this->lines = new ArrayCollection;
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
     * Set quote
     * 
     * @param Quote $quote
     * @return Coding
     */
    public function setQuote(\JLM\OfficeBundle\Entity\Quote $quote = null)
    {
    	$this->quote = $quote;
    	return $this;
    }
    
    /**
     * Get quote
     *
     * @return Quote
     */
    public function getQuote()
    {
    	return $this->quote;
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
     * Add lines
     *
     * @param JLM\ModelBundle\Entity\CodingLine $lines
     * @return Coding
     */
    public function addLine(\JLM\OfficeBundle\Entity\CodingLine $lines)
    {
    	$lines->setCoding($this);
        $this->lines[] = $lines;
    	
        return $this;
    }

    /**
     * Remove lines
     *
     * @param JLM\ModelBundle\Entity\CodingLine $lines
     */
    public function removeLine(\JLM\OfficeBundle\Entity\CodingLine $lines)
    {
    	$lines->setCoding();
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
     * Get Total HT
     */
    public function getTotalPrice()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    		$total += $line->getPrice();
    	$total *= (1-$this->getDiscount());
    	return $total;
    }
    
    /**
     * Get Total TVA
     */
    public function getTotalVat()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    		$total += $line->getVatValue();
    	$total *= (1-$this->getDiscount());
    	return $total;
    }
    
    /**
     * Get Total TTC
     */
    public function getTotalPriceAti()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    		$total += $line->getPriceAti();
    	$total *= (1-$this->getDiscount());
    	return $total;
    }
}