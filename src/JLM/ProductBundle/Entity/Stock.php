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

use JLM\ProductBundle\Model\StockInterface;
use JLM\ProductBundle\Model\ProductInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Stock implements StockInterface
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var ProductInterface
	 */
	private $product;
	
	/**
	 * @var \DateTime
	 */
	private $lastModified;
	
	/**
	 * @var float
	 */
	private $quantity;
	
	/**
	 * @var float
	 */
	private $minimum;
	
	/**
	 * @var float
	 */
	private $maximum;
	
	/**
	 * 
	 * @return number
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * 
	 * @param ProductInterface $product
	 * @return \JLM\ProductBundle\Entity\Movement
	 */
	public function setProduct(ProductInterface $product)
	{
		$this->product = $product;
		
		return $this;
	}
	
	/**
	 * 
	 * @return \JLM\ProductBundle\Entity\ProductInterface
	 */
	public function getProduct()
	{
		return $this->product;
	}
	
	/**
	 * 
	 * @param \DateTime $date
	 * @return \JLM\ProductBundle\Entity\Movement
	 */
	public function setLastModified(\DateTime $date = null)
	{
		$this->lastModified = ($date === null) ? new \DateTime : $date;
		
		return $this;
	}
	
	/**
	 * 
	 * @return DateTime
	 */
	public function getDate()
	{
		return $this->lastModified;
	}
	
	/**
	 * 
	 * @param unknown $quantity
	 * @return \JLM\ProductBundle\Entity\Movement
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		
		return $this;
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}
	
	/**
	 *
	 * @param unknown $minimum
	 * @return \JLM\ProductBundle\Entity\Movement
	 */
	public function setMinimum($quantity)
	{
		$this->minimum = $quantity;
	
		return $this;
	}
	
	/**
	 *
	 * @return number
	 */
	public function getMinimum()
	{
		return $this->minimum;
	}
	
	/**
	 *
	 * @param unknown $minimum
	 * @return \JLM\ProductBundle\Entity\Movement
	 */
	public function setMaximum($quantity)
	{
		$this->maximum = $quantity;
	
		return $this;
	}
	
	/**
	 *
	 * @return number
	 */
	public function getMaximum()
	{
		return $this->maximum;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isOutOfStock()
	{
		return $this->quantity <= 0;
	}
	
	/**
	 * @return boolean
	 */
	public function isUnderMinimum()
	{
		return $this->quantity < $this->minimum;
	}
	
	/**
	 * @return boolean
	 */
	public function getQuantityToOrder()
	{
		$toOrder = $this->maximum - $this->quantity;

		return ($toOrder > 0) ? $toOrder : 0;
	}
}