<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\SalableInterface;

use JLM\ProductBundle\Factory\PriceFactory;

class SalableProduct extends ProductDecorator implements SalableInterface
{
	/**
	 * 
	 * @var array
	 */
	private $sellPrices;
	
	/**
	 * 
	 * @var string
	 */
	private $sellUnity;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->sellPrices = PriceListFactory::createPriceList(); 
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addSellUnitPrice($price, $quantity = 1)
	{
		$this->sellPrices->add(PriceFactory::create($price, $quantity));
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function removeSellPrice($quantity)
	{
		$price = $this->_getSellPrice($quantity);
		$this->sellPrices->remove($price);
		
		return $this;
	}
	
	/**
	 * 
	 * @param decimal $quantity
	 * @return QuantitativePriceInterface|NULL
	 */
	private function _getSellPrice($quantity)
	{
		foreach ($this->sellPrices as $price)
		{
			if ($quantity == $price->getQuantity())
			{
				return $price;
			}
		}
		
		return null;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSellUnitPrice($quantity = 1)
	{			
    	$index = 0;
    	$q = $this->sellPrices[$index]->getQuantity();
    	while ($quantity >= $q)
    	{
    		// Quand on arrive au bout du tableau
    		if (!isset($this->sellPrices[$index+1]))
    			return $this->sellPrices[$index]->getValue();
    		$q = $this->sellPrices[++$index]->getQuantity();
    	} 
    	
    	return $this->sellPrices[$index-1]->getValue();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSellUnity()
	{
		return $this->sellUnity;
	}
}