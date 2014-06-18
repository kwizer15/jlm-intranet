<?php
namespace JLM\ProductBundle\Model;

interface PriceListInterface extends PriceInterface, \Iterator
{
	/**
	 * Add a price from quantity
	 *
	 * @param decimal $quantity
	 * @param decimal $price The price
	 * @return self
	 */
	public function add($quantity, $price);
	
	/**
	 * Remove a price
	 *
	 * @param decimal $quantity
	 * @return self
	 */
	public function remove($quantity);
	
	/**
	 * Get price for quantity
	 * 
	 * @param decimal $quantity
	 * @return decimal
	 */
	public function get($quantity = 0);
}