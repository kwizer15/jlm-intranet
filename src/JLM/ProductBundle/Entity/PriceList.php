<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\PriceInterface;
use JLM\ProductBundle\Model\PriceListInterface;
use JLM\ProductBundle\Factory\PriceFactory;
use JLM\ProductBundle\Model\QuantitativePriceInterface;

class PriceList implements PriceListInterface
{
	private $prices;

	private $key = 0;
	
	/**
	 * Constructor
	 */
	public function __construct($public)
	{
		$this->prices = new \Doctrine\Common\Collections\ArrayCollection();
		$this->add(0, $public);
	}
	
	/**
	 * Get price from exact quantity
	 *
	 * @param decimal $quantity
	 * @return PriceInterface|NULL
	 */
	private function _getExact($quantity)
	{
		foreach ($this as $price)
		{
			if ($price->getQuantity() == $quantity)
			{
				return $price;
			}
		}
		return null;
	}
	
	//------------------------
	// PriceListInterface methods
	//------------------------
	
	/**
	 * {@inheritdoc}
	 */
	public function add($quantity, $price)
	{
		$p = PriceFactory::createPrice($price, $quantity);
		if (!$p instanceof QuantitativePriceInterface)
		{
			throw new \LogicException('Created Price doesn\'t implements QuantitativePriceInterface');
		}
		$this->prices->add($p);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function remove($quantity)
	{
		$price = $this->_getExact($quantity);
		$this->prices->removeElement($price);
			
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function get($quantity = 0)
	{
		$tempq = 0;
		$key = 0;
		foreach ($this as $k => $price)
		{
			$q = $price->getQuantity();
			if ($quantity >= $q)
			{
				if ($q > $tempq)
				{
					$tempq = $q;
				}
			}
		}
		
		return $this->_getExact($tempq)->getValue();
	}
	
	//------------------------
	// PriceInterface methods
	//------------------------
	
	/**
	 * {@inheritdoc}
	 */
	public function getValue()
	{
		return $this->get();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getCurrency()
	{
		return $this->_getExact(0)->getCurrency();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		return $this->getValue().' '.$this->getCurrency();
	}
	
	//------------------
	// Iterator methods
	//------------------
	
	/**
	 * {@inheritdoc}
	 */
	public function current()
	{
		return $this->prices[$this->key];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function key()
	{
		return $this->key;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function next()
	{
		$this->key++;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rewind()
	{
		$this->key = 0;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function valid()
	{
		return isset($this->prices[$this->key]);
	}
}