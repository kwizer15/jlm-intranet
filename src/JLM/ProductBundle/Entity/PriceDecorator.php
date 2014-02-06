<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\PriceInterface;

abstract class PriceDecorator implements PriceInterface
{
	/**
	 * 
	 * @var decimal $value
	 */
	private $price;
	
	/**
	 * Constructor
	 * 
	 * @param PriceInterface $value
	 */
	public function __construct(PriceInterface $price)
	{
		$this->price = $price;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getValue()
	{
		return $this->price->getValue();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCurrency()
	{
		return $this->price->getCurrency();
	}

	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		return $this->price->__toString();
	}
}