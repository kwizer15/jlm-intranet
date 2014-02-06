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
	 * Get designation
	 * 
	 * @return string
	 */
	public function getDesignation();
	
	/**
	 * Get description
	 * 
	 * @return string
	 */
	public function getDescription();
	
	/**
	 * To string
	 * 
	 * @return string
	 */
	public function __toString();
}