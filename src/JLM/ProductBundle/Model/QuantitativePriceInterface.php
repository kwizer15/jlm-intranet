<?php
namespace JLM\ProductBundle\Model;

interface QuantitativePriceInterface extends PriceInterface
{	
	public function getQuantity();
}