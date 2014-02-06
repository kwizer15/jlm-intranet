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