<?php
namespace JLM\ProductBundle\Model;

interface PriceListInterface extends \IteratorAggregate
{
	/**
	 * Add a price from quantity
	 *
	 * @param decimal $quantity
	 * @param PriceInterface $price The price
	 * @return self
	 */
	public function add($quantity, PriceInterface $price);
	
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
	 * @return PriceInterface
	 */
	public function get($quantity = 0);
	
	/**
	 * Get public price
	 * 
	 * @return PriceInterface
	 */
	public function getPublic();
}