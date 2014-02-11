<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\QuantitativePriceInterface;
use JLM\ProductBundle\Model\PriceInterface;
use JLM\ProductBundle\Factory\PriceFactory;

class QuantitativePrice extends PriceDecorator implements QuantitativePriceInterface
{
	private $quantity;
	
	public function __construct(PriceInterface $price, $quantity)
	{
		parent::__construct($price);
		$this->quantity = $quantity;
	}
	
	public function getQuantity()
	{
		return $this->quantity;
	}
}