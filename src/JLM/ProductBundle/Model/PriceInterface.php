<?php
namespace JLM\ProductBundle\Model;

interface PriceInterface
{
	/**
	 * Get value
	 * 
	 * @return decimal
	 */
	public function getValue();
	
	/**
	 * Set value
	 *
	 * @param decimal
	 * @return PriceInterface
	 */
	public function setValue($price);
	
	/**
	 * Get currency
	 * 
	 * @return string
	 */
	public function getCurrency();
	
	/**
	 * To string
	 * 
	 * @return string
	 */
	public function __toString();
}