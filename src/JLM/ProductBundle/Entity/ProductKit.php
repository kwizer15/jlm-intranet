<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\ProductKitInterface;

class ProductKit extends ProductDecorator implements ProductKitInterface
{
	private $subProducts;
	
	public function __construct(ProductInterface $product)
	{
		parent::__construct($product);
		$this->subProducts = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addSubProduct(ProductInterface $product)
	{
		$this->subProducts->add($product);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function removeSubProduct(ProductInterface $product)
	{
		$this->subProducts->removeElement($product);
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getSubProducts()
	{
		return $this->subProducts;
	}
}