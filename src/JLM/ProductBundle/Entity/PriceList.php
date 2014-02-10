<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\PriceInterface;
use JLM\ProductBundle\Model\PriceListInterface;

class PriceList implements PriceListInterface
{
	private $prices;
	
	/**
	 * Constructor
	 */
	public function __construct(PriceInterface $public)
	{
		$this->prices = new \Doctrine\Common\Collections\ArrayCollection();
		$this->prices[0] = $public;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function add($quantity, PriceInterface $price)
	{
		$this->prices[$quantity] = $price;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function remove($quantity)
	{
		$price = $this->_getExact($quantity);
		$this->prices->remove($price);
			
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function get($quantity = 0)
	{
		// @todo Changer pour quantité minimum
		return $this->prices[$quantity];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getPublic()
	{
		return $this->get();
	}
	
	/**
	 * Get price from exact quantity
	 * 
	 * @param decimal $quantity
	 * @return PriceInterface|NULL
	 */
	private function _getExact($quantity)
	{
		if (isset($this->prices[$quantity]))
		{
			return $this->prices[$quantity];
		}
		
		return null;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return $this->prices;
	}
}