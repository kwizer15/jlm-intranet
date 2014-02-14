<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\WeightInterface;

class WeightProduct extends ProductDecorator implements WeightInterface
{
	/**
	 *
	 * @var PriceListInterface
	 */
	private $weight;
	
	/**
	 * Constructor
	 *
	 * @param ProductInterface $product
	 * @param decimal $weight
	 */
	public function __construct(ProductInterface $product, $weight)
	{
		parent::__construct($product);
		$this->setWeight($weight);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getWeight()
	{
		return $this->weight;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setWeight($weight)
	{
		$this->weight = $weight;
		
		return $this;
	}
}