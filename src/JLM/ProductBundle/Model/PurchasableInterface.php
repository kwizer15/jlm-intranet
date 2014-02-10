<?php
namespace JLM\ProductBundle\Model;

interface PurchasableInterface
{
	/**
	 * Get supplier
	 * 
	 * @return Supplier
	 */
	public function getSupplier();
	
	/**
	 * Set supplier
	 *
	 * @return self
	 */
	public function setSupplier(SupplierInterface $supplier);
	
	/**
	 * Get public price
	 * 
	 * @return decimal
	 */
	public function getPublicPrice();
	
	/**
	 * Set public price
	 *
	 * @return self
	 */
	public function setPublicPrice($price);
	
	/**
	 * Get unity
	 * 
	 * @return decimal
	 */
	public function getPuchaseUnitPrice($quantity = 1);
	
	/**
	 * Add purchase unit price
	 * 
	 * @param decimal $discount
	 * @param decimal $quantity
	 * @return self
	 */
	public function addPurchaseUnitPrice($quantity, $price);
	
	/**
	 * Remove purchase unit price
	 *
	 * @param decimal $quantity
	 * @return self
	 */
	public function removePurchaseUnitPrice($quantity);
	
	/**
	 * Get purchase unity
	 *
	 * @return string
	 */
	public function getPurchaseUnity();
}