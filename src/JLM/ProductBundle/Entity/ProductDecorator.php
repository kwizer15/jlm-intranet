<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;

abstract class ProductDecorator implements ProductInterface
{
	/**
	 * 
	 * @var ProductInterface
	 */
	private $product;
	
	/**
	 * Constructor
	 * 
	 * @param ProductInterface $product
	 */
	public function __construct(ProductInterface $product)
	{
		$this->product = $product;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setReference($reference)
	{
		return $this->product->setReference($reference);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getReference()
	{
		return $this->product->getReference();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDesignation($designation)
	{
		return $this->product->setDesignation($designation);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDesignation()
	{
		return $this->product->getDesignation();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setDescription($description)
	{
		return $this->product->setDescription($description);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return $this->product->getDescription();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		return $this->product->__toString();
	}
}