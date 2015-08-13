<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface SupplierPurchasePriceInterface
{
	/**
	 * Get supplier
	 *
	 * @return SupplierInterface
	 */
	public function getSupplier();
	
	/**
	 * Get supplier reference
	 *
	 * @return float
	 */
	public function getReference();
	
	/**
	 * Get unit price
	 *
	 * @return float
	 */
	public function getUnitPrice();
	
	/**
	 * Get public price
	 *
	 * @return float
	 */
	public function getDiscount();
	
	/**
	 * Get public price
	 *
	 * @return float
	 */
	public function getPublicPrice();
	
	/**
	 * Get delivery rules
	 *
	 * @return DeliveryRuleInterface[]
	 */
	public function getDelivery();
	
	/**
	 * Get expense ratio
	 * 
	 * @return float
	 */
	public function getExpenseRatio();
	
	/**
	 * Get the real purchase price (with ratio and delivery)
	 */
	public function getTotalPrice();
}