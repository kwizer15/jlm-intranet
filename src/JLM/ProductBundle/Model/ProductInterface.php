<?php
namespace JLM\ProductBundle\Model;

interface ProductInterface
{
	/**
	 * Get reference
	 *
	 * @return string
	 */
	public function getReference();
	
	/**
	 * Set reference
	 *
	 * @param string $reference
	 * @return self
	 */
	public function setReference($reference);
	
	/**
	 * Get designation
	 * 
	 * @return string
	 */
	public function getDesignation();
	
	/**
	 * Set designation
	 *
	 * @param string $designation
	 * @return self
	 */
	public function setDesignation($designation);
	
	/**
	 * Get description
	 * 
	 * @return string
	 */
	public function getDescription();
	
	/**
	 * Set description
	 *
	 * @param string $description
	 * @return self
	 */
	public function setDescription($description);
	
	/**
	 * To string
	 * 
	 * @return string
	 */
	public function __toString();
}