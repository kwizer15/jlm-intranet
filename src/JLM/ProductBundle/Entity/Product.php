<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;

/**
 * @author kwizer
 *
 */
abstract class Product implements ProductInterface
{
	/**
	 * Product reference
	 * 
	 * @var string
	 */
	private $reference;
	
	/**
	 * Product designation
	 * 
	 * @var string
	 */
	private $designation;
	
	/**
	 * Product description
	 * 
	 * @var string
	 */
	private $description;
	
	/**
	 * {@inheritdoc}
	 */
	public function getReference()
	{
		return $this->reference;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setReference($reference)
	{
		$this->reference = $reference;
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDesignation()
	{
		return $this->designation;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setDesignation($designation)
	{
		$this->designation = $designation;
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		return $this->getDesignation();
	}
}