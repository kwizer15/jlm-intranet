<?php
namespace JLM\ProductBundle\Factory;

use JLM\ProductBundle\Entity\PriceEuro;
use JLM\ProductBundle\Entity\QuantitativePrice;

class PriceFactory
{
	/**
	 * 
	 * @param decimal $price
	 * @param decimal|NULL $quantity
	 * @return \JLM\ProductBundle\Factory\PriceEuro|\JLM\ProductBundle\Factory\QuantitativePrice
	 */
	public static function createPrice($price, $quantity = null)
	{
		if ($quantity === null)
		{
			return new PriceEuro($price);
		}
		return new QuantitativePrice(new PriceEuro($price), $quantity);
	}
	
	private function __construct()
	{
		
	}
	
	private function __clone() {}
}