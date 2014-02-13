<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\PriceInterface;

class PriceEuro implements PriceInterface
{
	/**
	 * 
	 * @var decimal $value
	 */
	private $value;
	
	/**
	 * Constructor
	 * 
	 * @param decimal $value
	 */
	public function __construct($value)
	{
		$this->setValue($value);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	*/
	public function getCurrency()
	{
		return '€';
	}

	/**
	 * {@inheritdoc}
	*/
	public function __toString()
	{
		return $this->getValue().' '.$this->getCurrency();
	}
}