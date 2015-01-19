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

use JLM\ProductBundle\Model\MovementInterface;
use JLM\ProductBundle\Model\ProductInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Movement implements MovementInterface
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
	private $date;
	
	/**
	 * @var float
	 */
	private $quantity;
	
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
	public function setDate(\DateTime $date = null)
	{
		$this->date = ($date === null) ? new \DateTime : $date;
		
		return $this;
	}
	
	/**
	 * 
	 * @return DateTime
	 */
	public function getDate()
	{
		return $this->date;
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
	 * @return boolean
	 */
	public function isOut()
	{
		return $this->quantity < 0;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isIn()
	{
		return $this->quantity > 0;
	}
}