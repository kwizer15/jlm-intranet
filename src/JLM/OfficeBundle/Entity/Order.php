<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\OfficeBundle\Entity\Bill
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity
 */
class Order
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
	 * Lignes
	 * @var ArrayCollection $lines
	 * @ORM\OneToMany(targetEntity="OrderLine", mappedBy="order")
	 */
	private $lines;
	
	/**
	 * Lieu
	 * @var string $place
	 * @ORM\Column(name="place",type="text") 
	 */
	private $place;
	
	/**
	 * Devis source
	 * @var Quote
	 * @ORM\ManyToOne(targetEntity="QuoteVariant")
	 */
	private $quote;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lines = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set place
     *
     * @param string $place
     * @return Order
     */
    public function setPlace($place)
    {
        $this->place = $place;
    
        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Add lines
     *
     * @param JLM\OfficeBundle\Entity\OrderLine $lines
     * @return Order
     */
    public function addLine(\JLM\OfficeBundle\Entity\OrderLine $lines)
    {
        $this->lines[] = $lines;
    
        return $this;
    }

    /**
     * Remove lines
     *
     * @param JLM\OfficeBundle\Entity\OrderLine $lines
     */
    public function removeLine(\JLM\OfficeBundle\Entity\OrderLine $lines)
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
     * Set quote
     *
     * @param JLM\OfficeBundle\Entity\QuoteVariant $quote
     * @return Order
     */
    public function setQuote(\JLM\OfficeBundle\Entity\QuoteVariant $quote = null)
    {
        $this->quote = $quote;
    
        return $this;
    }

    /**
     * Get quote
     *
     * @return JLM\OfficeBundle\Entity\QuoteVariant 
     */
    public function getQuote()
    {
        return $this->quote;
    }
}