<?php
namespace JLM\ProductBundle\Model;

use JLM\ContactBundle\Model\SupplierInterface;

interface SupplierPriceInterface extends PriceInterface
{
	/**
	 * Get the supplier
	 * 
	 * @return SupplierInterface
	 */
	public function getSupplier();
	
	/**
	 * Set the supplier
	 * 
	 * @param SupplierInterface
	 * @return self
	 */
	public function setSupplier(SupplierInterface $supplier);
}