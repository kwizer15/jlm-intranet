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
	private $publicPrice;
	
	/**
	 * @var float
	 */
	private $delivery;
	
	/**
	 * @var float
	 */
	private $expense;
	
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
		$unitPrice = $this->_filterPrice($unitPrice);;
		$this->unitPrice = $unitPrice;
		if ($this->publicPrice < $unitPrice)
		{
			$this->setPublicPrice($unitPrice);
		}
		
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
		$discount = self::_filterPrice($discount);
		$discount = ($discount > 100) ? 0.0 : $discount;
		$this->unitPrice = $this->publicPrice * (1 - $discount / 100);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDiscount()
	{
		return ($this->publicPrice == 0) ? 0 : (1 - ($this->unitPrice / $this->publicPrice)) * 100;
	}
	
	/**
	 * Set the public price
	 *
	 * @param float $publicPrice
	 * @return self
	 */
	public function setPublicPrice($publicPrice)
	{
		$publicPrice = self::_filterPrice($publicPrice);
		$this->publicPrice = $publicPrice;
		if ($this->unitPrice == 0 || $this->unitPrice > $publicPrice)
		{
			$this->unitPrice = $publicPrice;
		}
		
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
		$this->delivery = self::_filterPrice($delivery);
		
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
		// @todo change with ratio
		$expenseRatio = self::_filterPrice($expenseRatio);
		$this->expense = $this->unitPrice * ($expenseRatio / 100);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getExpenseRatio()
	{
		return ($this->unitPrice == 0) ? 0 : ($this->expense * 100) / $this->unitPrice;
	}
	
	/**
	 * Set the expense
	 *
	 * @param float $expense
	 * @return self
	 */
	public function setExpense($expense)
	{
		$this->expense = self::_filterPrice($expense);
	
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getExpense()
	{
		return $this->expense;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getTotalPrice()
	{
		return $this->getUnitPrice() + $this->getExpense() + $this->getDelivery();
	}
	
	private static function _filterPrice($price)
	{
		return (!is_numeric($price) || $price < 0) ? 0.0 : (float)$price;
	}
}