<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\ProductPriceInterface;
use JLM\ProductBundle\Model\SupplierInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ProductBundle\Model\PriceInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PurchaseProduct extends ProductDecorator
{
	/**
	 * @var SupplierInterface
	 */
	private $supplier;
	
	/**
	 * @var string
	 */
	private $supplierReference;
	
	/**
	 * @var PurchasePriceInterface[]
	 */
	private $purchasePrices;
	
	/**
	 * Construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->purchasePrices = new ArrayCollection();
	}
	
	/**
	 * Set supplier
	 * @param SupplierInterface $supplier
	 * @return self
	 */
	public function setSupplier(SupplierInterface $supplier)
	{
		$this->supplier = $supplier;
		
		return $this;
	}
	
	/**
	 * Get supplier
	 * @return SupplierInterface
	 */
	public function getSupplier()
	{
		return $this->supplier;
	}
	
	/**
	 * Get supplier reference
	 * @param string $reference
	 * @return self
	 */
	public function setSupplierReference($reference)
	{
		$this->supplierReference = $reference;
		
		return $this;
	}
	
	/**
	 * Get suppleri reference
	 * @return string
	 */
	public function getSupplierReference()
	{
		return $this->supplierReference;
	}
	
	/**
	 * Add a purchase price
	 * @param PurchasePriceInterface $price
	 * @return bool
	 */
	public function addPurchasePrice(PriceInterface $price)
	{
		return $this->purchasePrices->add($price);
	}
	
	/**
	 * Remove a purchase price
	 * @param PurchasePriceInterface $price
	 * @return bool
	 */
	public function removePurchasePrice(PriceInterface $price)
	{
		return $this->purchasePrices->removeElement($price);
	}
	
	/**
	 * Get purchase prices
	 * @return PurchasePriceInterface[]
	 */
	public function getPurchasePrices()
	{
		return $this->purchasePrices;
	}
}