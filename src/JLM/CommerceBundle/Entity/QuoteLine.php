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

use JLM\CommerceBundle\Entity\CommercialPartLineProduct;
use JLM\CommerceBundle\Model\QuoteLineInterface;
use JLM\CommerceBundle\Model\QuoteVariantInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteLine extends CommercialPartLineProduct implements QuoteLineInterface
{
	/**
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @var float $purchasePrice
	 */
	private $purchasePrice = 0;
	
	/**
	 * Remise Fournisseur (%)
	 * @var float $discountSupplier
	 */
	private $discountSupplier = 0;
	
	/**
	 * Frais (%)
	 * @var float $expenseRatio
	 */
	private $expenseRatio = .1;
	
	/**
	 * Frais de port (€)
	 * @var float $shipping
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
     * @return self
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
     * {@inheritdoc}
     */
    public function setVariant(QuoteVariantInterface $variant = null)
    {
        $this->variant = $variant;
    
        return $this;
    }

    /**
     * Get variant
     *
     * @return QuoteVariantInterface 
     */
    public function getVariant()
    {
        return $this->variant;
    }

    
    
    /**
     * Set purchasePrice
     *
     * @param float $price
     * @return self
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
     * @return self
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