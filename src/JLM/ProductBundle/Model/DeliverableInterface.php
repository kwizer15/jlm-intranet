<?php
namespace JLM\ProductBundle\Model;

interface DeliverableInterface extends PurchasableInterface
{
	/**
	 * Get Shipping
	 * 
	 * @return decimal
	 */
	public function getShipping();
}