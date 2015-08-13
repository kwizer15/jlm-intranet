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

use JLM\ProductBundle\Model\SupplierPurchasePriceInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SupplierPurchasePrice implements SupplierPurchasePriceInterface
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var SupplierInterface
	 */
	private $supplier;
	
	/**
	 * @var string
	 */
	private $reference;
	
	/**
	 * @var float
	 */
	private $unitPrice;
	
	/**
	 * @var float
	 */
	private $discount;
	
	/**
	 * @var float
	 */
	private $publicPrice;
	
	/**
	 * @var float
	 */
	private $delivery;
	
	/**
	 * @var float
	 */
	private $expenseRatio;
	
	/**
	 * Get id
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set the supplier
	 *
	 * @param SupplierInterface $supplier
	 * @return self
	 */
	public function setSupplier($supplier)
	{
		$this->supplier = $supplier;
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSupplier()
	{
		return $this->supplier;
	}
	
	/**
	 * Set the reference
	 *
	 * @param string $reference
	 * @return self
	 */
	public function setReference($reference)
	{
		$this->reference = $reference;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getReference()
	{
		return $this->reference;
	}
	
	/**
	 * Set the unit price
	 *
	 * @param float $unitPrice
	 * @return self
	 */
	public function setUnitPrice($unitPrice)
	{
		$this->unitPrice = (!is_numeric($unitPrice) || $unitPrice < 0) ? 0.0 : (float)$unitPrice;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getUnitPrice()
	{
		return $this->unitPrice;
	}
	
	/**
	 * Set the discount
	 *
	 * @param float $discount
	 * @return self
	 */
	public function setDiscount($discount)
	{
		$this->discount = (!is_numeric($discount) || $discount < 0 || $discount > 100) ? 0.0 : (float)$discount;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDiscount()
	{
		return $this->discount;
	}
	
	/**
	 * Set the public price
	 *
	 * @param float $publicPrice
	 * @return self
	 */
	public function setPublicPrice($publicPrice)
	{
		$this->publicPrice = $publicPrice;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getPublicPrice()
	{
		return $this->publicPrice;
	}
	
	/**
	 * Set the delivery
	 *
	 * @param float $delivery
	 * @return self
	 */
	public function setDelivery($delivery)
	{
		$this->delivery = (!is_numeric($delivery) || $delivery < 0) ? 0.0 : (float)$delivery;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDelivery()
	{
		return $this->delivery;
	}
	
	/**
	 * Set the expense ratio
	 *
	 * @param float $expenseRatio
	 * @return self
	 */
	public function setExpenseRatio($expenseRatio)
	{
		$this->expenseRatio = (!is_numeric($expenseRatio) || $expenseRatio < 0) ? 0.0 : (float)$expenseRatio;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getExpenseRatio()
	{
		return $this->expenseRatio;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getTotalPrice()
	{
		return $this->getUnitPrice() * (1 - $this->getDiscount() / 100) * (1 + $this->getExpenseRatio() / 100) + $this->getDelivery();
	}
}