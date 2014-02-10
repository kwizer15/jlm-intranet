<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\QuantitativePriceInterface;
use JLM\ProductBundle\Model\PriceInterface;
use JLM\ProductBundle\Factory\PriceFactory;

class QuantitativePrice implements QuantitativePriceInterface
{
	private $prices;
	
	public function __construct(PriceInterface $price)
	{
		$this->prices = PriceFactory::createPriceArray();
		$this->addPrice(1, $price);
	}
	
	public function addPrice($quantity, PriceInterface $price)
	{
		 return $this;
	}
	
	public function removePrice($quantity)
	{
		if ($quantity != 1)
		{
			
		}
		return $this;
	}
	
	public function getPrice($quantity)
	{
		foreach ($this->prices as $price)
		{
			
		}
	}
}