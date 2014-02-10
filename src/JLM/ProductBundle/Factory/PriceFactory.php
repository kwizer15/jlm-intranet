<?php
namespace JLM\ProductBundle\Factory;

class PriceFactory
{
	public static function create($price, $quantity = 1)
	{
		return new QuantitativePrice($price, $quantity);
	}
	
	private function __construct()
	{
		
	}
	
	private function __clone() {}
}