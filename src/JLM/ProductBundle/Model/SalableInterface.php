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
	public function addSellUnitPrice($quantity, $price);
	
	/**
	 * Remove sell unit price
	 *
	 * @param decimal $quantity
	 * @return self
	*/
	public function removeSellUnitPrice($quantity);
	
	/**
	 * Get unity
	 * 
	 * @return string
	 */
	public function getSellUnity();
	
	/**
	 * Set unity
	 *
	 * @param string $unity
	 * @return self
	 */
	public function setSellUnity($unity);
}