<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\QuoteRepository")
 */
class Quote extends Document
{
	/**
	 * Numéro du devis
	 * @var int $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @todo Construire automatiquement
	 */
	private $id;
	
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
	 * @ORM\ManyToOne(targetEntity="Door")
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
	 * Texte d'intro
	 * @var string $intro
	 * 
	 * @ORM\Column(name="intro",type="text")
	 */
	private $intro;
	
	/**
	 * @var string $paymentRules
	 *
	 * @ORM\Column(name="payment_rules", type="string", length=255)
	 */
	private $paymentRules;
	
	/**
	 * @var string $deliveryRules
	 *
	 * @ORM\Column(name="delivery_rules", type="string", length=255)
	 */
	private $deliveryRules;
	
	/**
	 * @var string $customerComments
	 *
	 * @ORM\Column(name="customer_comments", type="text", nullable=true)
	 */
	private $customerComments;
	
	/**
	 * Accordé
	 * @var bool $given
	 * 
	 * @ORM\Column(name="given",type="boolean")
	 */
	private $given = false;

	/**
	 * Lignes
	 * @var ArrayCollection $lines
	 * 
	 * @ORM\OneToMany(targetEntity="QuoteLine",mappedBy="quote")
	 * @ORM\OrderBy({"position" = "ASC"})
	 */
	private $lines;
	
	/**
	 * @var SiteContact $contact
	 * 
	 * @ORM\ManyToOne(targetEntity="SiteContact")
	 */
	private $contact;
	
	/**
	 * @var string $contactCp
	 * 
	 * @ORM\Column(name="contact_cp", type="string")
	 */
	private $contactCp;
	
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
     * Set paymentRules
     *
     * @param string $paymentRules
     * @return Quote
     */
    public function setPaymentRules($paymentRules)
    {
        $this->paymentRules = $paymentRules;
    
        return $this;
    }

    /**
     * Get paymentRules
     *
     * @return string 
     */
    public function getPaymentRules()
    {
        return $this->paymentRules;
    }

    /**
     * Set deliveryRules
     *
     * @param string $deliveryRules
     * @return Quote
     */
    public function setDeliveryRules($deliveryRules)
    {
        $this->deliveryRules = $deliveryRules;
    
        return $this;
    }

    /**
     * Get deliveryRules
     *
     * @return string 
     */
    public function getDeliveryRules()
    {
        return $this->deliveryRules;
    }

    /**
     * Set customerComments
     *
     * @param string $customerComments
     * @return Quote
     */
    public function setCustomerComments($customerComments)
    {
        $this->customerComments = $customerComments;
    
        return $this;
    }

    /**
     * Get customerComments
     *
     * @return string 
     */
    public function getCustomerComments()
    {
        return $this->customerComments;
    }

    /**
     * Set given
     *
     * @param boolean $given
     * @return Quote
     */
    public function setGiven($given)
    {
        $this->given = $given;
    
        return $this;
    }

    /**
     * Get given
     *
     * @return boolean 
     */
    public function getGiven()
    {
        return $this->given;
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
    
    public function getIntro()
    {
    	return $this->intro;
    }
    
    public function setIntro($intro)
    {
    	$this->intro = $intro;
    	return $this;
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
     * @param JLM\ModelBundle\Entity\QuoteLine $lines
     * @return Quote
     */
    public function addLine(\JLM\ModelBundle\Entity\QuoteLine $lines)
    {
    	$lines->setQuote($this);
        $this->lines[] = $lines;
    	
        return $this;
    }

    /**
     * Remove lines
     *
     * @param JLM\ModelBundle\Entity\QuoteLine $lines
     */
    public function removeLine(\JLM\ModelBundle\Entity\QuoteLine $lines)
    {
    	$lines->setQuote();
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