<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\OfficeBundle\Entity\QuoteLine
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
	 * @var QuoteVariant $variant
	 * 
	 * @ORM\ManyToOne(targetEntity="QuoteVariant",inversedBy="lines")
	 */
	private $variant;
	
	/**
	 * Position de la ligne dans le devis
	 * @var position
	 * 
	 * @ORM\Column(name="position", type="smallint", nullable=true)
	 */
	private $position = 0;
	
	/**
	 * @var JLM\ModelBundle\Entity\Product
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Product")
	 */
	private $product;
	
	/**
	 * @var string $reference
	 * 
	 * @ORM\Column(name="reference", nullable=true)
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
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;
	
	/**
	 * @var bool $showDescription
	 *
	 * @ORM\Column(name="show_description", type="boolean", nullable=true)
	 */
	private $showDescription;
	
	/**
	 * @var bool $isTransmitter
	 *
	 * @ORM\Column(name="is_transmitter", type="boolean", nullable=true)
	 */
	private $isTransmitter = false;
	
	/**
	 * @var int $quantity
	 * 
	 * @ORM\Column(name="quantity", type="integer")
	 */
	private $quantity = 1;
	
	// Chiffrage ********************************************
	
	/**
	 * @var float $purchasePrice
	 *
	 * @ORM\Column(name="purchasePrice", type="decimal",scale=2)
	 */
	private $purchasePrice;
	
	/**
	 * Remise Fournisseur (%)
	 * @var float $discountSupplier
	 * 
	 * @ORM\Column(name="discount_supplier", type="decimal", scale=7)
	 */
	private $discountSupplier;
	
	/**
	 * Frais (%)
	 * @var float $expenseRatio
	 *
	 * @ORM\Column(name="expense_ratio", type="decimal", scale=7)
	 */
	private $expenseRatio;
	
	/**
	 * Frais de port (€)
	 * @var float $shipping
	 *
	 * @ORM\Column(name="shipping", type="decimal", scale=2)
	 */
	private $shipping;
	
	/**
	 * Prix de vente unitaire (€)
	 * NB : Pas de coefficient, celui-ci est calculé 
	 * via PA total (inclue remise fournisseur, frais,
	 * port) et PV
	 * 
	 * @var float $unitPrice
	 *
	 * @ORM\Column(name="unit_price", type="decimal",scale=2)
	 */
	private $unitPrice;
	
	/**
	 * Remise (%)
	 * @var float $discount
	 *
	 * @ORM\Column(name="discount", type="decimal",scale=7)
	 */
	private $discount = 0;
	
	/**
	 * TVA applicable (en %)
	 * TVA sur tout les produit sauf les emetteurs
	 * @var float $vat
	 *
	 * @ORM\Column(name="vat", type="decimal",precision=3,scale=3)
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
     * Set position
     *
     * @param int $position
     * @return QuoteLine
     */
    public function setPosition($position)
    {
    	$this->position = $position;
    
    	return $this;
    }
    
    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
    	return $this->position;
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
     * Set discountSupplier
     *
     * @param float $discountSupplier
     * @return QuoteLine
     */
    public function setDiscountSupplier($discountSupplier)
    {
    	$this->discountSupplier = $discountSupplier;
    
    	return $this;
    }
    
    /**
     * Get discount
     *
     * @return float
     */
    public function getDiscountSupplier()
    {
    	return $this->discountSupplier;
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

    /**
     * Set variant
     *
     * @param JLM\ModelBundle\Entity\QuoteVariant $variant
     * @return QuoteLine
     */
    public function setVariant(\JLM\OfficeBundle\Entity\QuoteVariant $variant = null)
    {
        $this->variant = $variant;
    
        return $this;
    }

    /**
     * Get variant
     *
     * @return JLM\OfficeBundle\Entity\QuoteVariant 
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Set product
     *
     * @param JLM\ModelBundle\Entity\Product $product
     * @return QuoteLine
     */
    public function setProduct(\JLM\ModelBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return JLM\ModelBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * Get Total HT
     * 
     * @return float
     */
    public function getPrice()
    {
    	return ($this->getUnitPrice() * $this->getQuantity()) * (1 - $this->getDiscount());
    }
    
    /**
     * Get Total TVA
     * 
     * @return float
     */
    public function getVatValue()
    {
    	return $this->getPrice()*$this->getVat();
    }
    
    /**
     * Get Total TTC
     */
    public function getPriceAti()
    {
    	return $this->getPrice()*(1 + $this->getVat());
    }
    
    /**
     * Set Is Transmitter
     * 
     * @param bool $tr
     * @return Quote
     */
    public function setIsTransmitter($tr)
    {
    	$this->isTransmitter = (bool)$tr;
    	return $this;
    }
    
    /**
     * Get Is Transmitter
     * 
     * @return bool
     */
    public function getIsTransmitter()
    {
    	return $this->isTransmitter;
    }
    
    /**
     * Set purchasePrice
     *
     * @param float $price
     * @return QuoteLine
     */
    public function setPurchasePrice($price)
    {
    	 $this->purchasePrice = $price;
    	 return $this;
    }
    
    /**
     * Get purchasePrice
     * 
     * @return float
     */
    public function getPurchasePrice()
    {
    	return $this->purchasePrice;
    }
    
    /**
     * Set expenseRatio
     * 
     * @param float $ratio
     * @return QuoteLine
     */
    public function setExpenseRatio($ratio)
    {
    	$this->expenseRatio = $ratio;
    	return $this;
    }
    
    /**
     * Get expenseRatio
     * 
     * @return float
     */
    public function getExpenseRatio()
    {
    	return $this->expenseRatio;
    }
    
    /**
     * Set shipping
     * 
     * @param float $shipping
     * @return QuoteLine
     */
    public function setShipping($shipping)
    {
    	$this->shipping = $shipping;
    	return $this;
    }
    
    /**
     * Get shipping
     * 
     * @return float
     */
    public function getShipping()
    {
    	return $this->shipping;
    }
    
    /**
     * Get totalUnitPurshasePrice (€)
     * 
     * @return float
     */
    public function getTotalUnitPurchasePrice()
    {
    	return $this->getPurchasePrice()*(1+$this->getExpenseRatio())+$this->getShipping();
    }
    
    /**
     * Get totalPurshasePrice (€)
     *
     * @return float
     */
    public function getTotalPurchasePrice()
    {
    	return $this->getTotalUnitPurchasePrice()*$this->getQuantity();
    }
    
    /**
     * Get marginRate (%)
     * 
     * @return float
     */
    public function getMarginRate()
    {
    	return ($this->getSellPrice()/$this->getTotalPurchasePrice())-1;
    }
    
    /**
     * Get sellPrice
     */
    public function getSellPrice()
    {
    	return $this->getUnitPrice()*(1-$this->getDiscount());
    }
    
    /**
     * Get margin (€)
     * 
     * @return float
     */
    public function getMargin()
    {
    	return $this->getSellPrice()-$this->getTotalPurchasePrice();
    }
    
    /**
     * Get totalMargin (€)
     *
     * @return float
     */
    public function getTotalMargin()
    {
    	return $this->getMargin()*$this->getQuantity();
    }
}