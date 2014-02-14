<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\SalableInterface;

use JLM\ProductBundle\Factory\PriceFactory;

class SalableProduct extends ProductDecorator implements SalableInterface
{
	/**
	 * 
	 * @var PriceListInterface
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
	public function __construct(ProductInterface $product, $price, $unity = null)
	{
		parent::__construct($product);
		$this->setSellUnity($unity);
		$this->sellPrices = PriceFactory::createPriceList($price); 
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addSellUnitPrice($quantity, $price)
	{
		$this->sellPrices->add($quantity, $price);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function removeSellUnitPrice($quantity)
	{
		$this->sellPrices->remove($quantity);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSellUnitPrice($quantity = 1)
	{			
    	return $this->sellPrices->get($quantity);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSellUnity()
	{
		return $this->sellUnity;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setSellUnity($unity)
	{
		$this->sellUnity = $unity;
		return $this;
	}
}