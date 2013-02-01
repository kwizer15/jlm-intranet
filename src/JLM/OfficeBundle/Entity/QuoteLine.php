<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\OfficeBundle\Entity\QuoteLine
 *
 * @ORM\Table(name="quote_lines")
 * @ORM\Entity
 */
class QuoteLine extends DocumentLine
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
	
	
	
	// Chiffrage ********************************************
	
	/**
	 * @var float $purchasePrice
	 *
	 * @ORM\Column(name="purchasePrice", type="decimal",scale=2)
	 */
	private $purchasePrice = 0;
	
	/**
	 * Remise Fournisseur (%)
	 * @var float $discountSupplier
	 * 
	 * @ORM\Column(name="discount_supplier", type="decimal", scale=7)
	 */
	private $discountSupplier = 0;
	
	/**
	 * Frais (%)
	 * @var float $expenseRatio
	 *
	 * @ORM\Column(name="expense_ratio", type="decimal", scale=7)
	 */
	private $expenseRatio = .1;
	
	/**
	 * Frais de port (€)
	 * @var float $shipping
	 *
	 * @ORM\Column(name="shipping", type="decimal", scale=2)
	 */
	private $shipping = 0;
	
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
    	return $this->getPurchasePrice()*(1-$this->getDiscountSupplier())*(1+$this->getExpenseRatio())+$this->getShipping();
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