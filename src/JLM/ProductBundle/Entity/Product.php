<?php
namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;

class Product implements ProductInterface
{
	/**
	 * 
	 * @var string
	 */
	private $reference;
	
	/**
	 * 
	 * @var string
	 */
	private $designation;
	
	/**
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
	 * Set the reference
	 * 
	 * @param string $reference The reference
	 * @return self
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
	 * Set the designation
	 *
	 * @param string $designation The designation
	 * @return self
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
	 * Set the description
	 *
	 * @param string $description The description
	 * @return self
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