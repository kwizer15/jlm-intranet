<?php
namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\QuoteLine
 *
 * @ORM\Table(name="quote_lines")
 * @ORM\Entity
 */
class QuoteLine
{
	/**
	 * @var integer $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO") 
	 */
	private $id;
	
	/**
	 * @var Product
	 * @todo A faire
	 */
	
	/**
	 * @var string $reference
	 * 
	 * @ORM\Column(name="reference")
	 */
	private $reference;
	
	/**
	 * @var string $designation
	 *
	 * @ORM\Column(name="designation")
	 */
	private $designation;
	
	/**
	 * @var string $description
	 *
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;
	
	/**
	 * @var bool $showDescription
	 *
	 * @ORM\Column(name="show_description", type="boolean")
	 */
	private $showDescription;
	
	/**
	 * @var int $quantity
	 * 
	 * @ORM\Column(name="quantity", type="integer")
	 */
	private $quantity;
	
	/**
	 * @var float $unitPrice
	 *
	 * @ORM\Column(name="unit_price", type="decimal",scale=2)
	 */
	private $unitPrice;
	
	/**
	 * Remise (en %)
	 * @var float $discount
	 *
	 * @ORM\Column(name="discount", type="decimal",scale=7)
	 */
	private $discount;
	
	/**
	 * TVA (en %)
	 * @var float $vat
	 *
	 * @ORM\Column(name="vat", type="decimal",scale=7)
	 */
	private $vat;

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
     * Set reference
     *
     * @param string $reference
     * @return QuoteLine
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
     * Set designation
     *
     * @param string $designation
     * @return QuoteLine
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    
        return $this;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return QuoteLine
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set showDescription
     *
     * @param boolean $showDescription
     * @return QuoteLine
     */
    public function setShowDescription($showDescription)
    {
        $this->showDescription = $showDescription;
    
        return $this;
    }

    /**
     * Get showDescription
     *
     * @return boolean 
     */
    public function getShowDescription()
    {
        return $this->showDescription;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return QuoteLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     * @return QuoteLine
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    
        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float 
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set discount
     *
     * @param float $discount
     * @return QuoteLine
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
     * Set vat
     *
     * @param float $vat
     * @return QuoteLine
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
}