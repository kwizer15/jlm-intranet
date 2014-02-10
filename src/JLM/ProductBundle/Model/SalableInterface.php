<?php
namespace JLM\ProductBundle\Model;

interface SalableInterface
{
	/**
	 * Get sell unit price
	 * 
	 * @return decimal
	 */
	public function getSellUnitPrice($quantity = 1);
	
	/**
	 * Add sell unit price
	 *
	 * @param decimal price
	 * @param decimal $quantity
	 * @return self
	 */
	public function addSellUnitPrice($price, $quantity = 1);
	
	/**
	 * Remove sell unit price
	 *
	 * @param decimal $quantity
	 * @return self
	*/
	public function removeSellPrice($quantity);
	
	/**
	 * Get unity
	 * 
	 * @return string
	 */
	public function getSellUnity();
}