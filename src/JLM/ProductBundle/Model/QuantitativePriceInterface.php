<?php
namespace JLM\ProductBundle\Model;

interface QuantitativePriceInterface
{
	/**
	 * 
	 * @param PriceInterface $price Price for quantity = 1
	 */
	public function __construct(PriceInterface $price);
	
	/**
	 * Add a price from quantity
	 * 
	 * @param decimal $quantity The minimum quantity for price 
	 * @param PriceInterface $price The price
	 * @return self
	 */
	public function addPrice($quantity, PriceInterface $price);
	
	/**
	 * Remove a price from quantity
	 *
	 * @param decimal $quantity The minimum quantity for price
	 * @return self
	 */
	public function removePrice($quantity);
	
	/**
	 * Get unit price for the given quantity
	 * @param decimal $quantity
	 * 
	 * @return PriceInterface
	 */
	public function getPrice($quantity);
}