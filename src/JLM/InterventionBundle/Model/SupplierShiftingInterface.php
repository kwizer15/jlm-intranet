<?php
namespace JLM\InterventionBundle\Model;

use JLM\ProductBundle\Model\SupplierInterface;

/**
 * SupplierShiftingInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface SupplierShiftingInterface extends ShiftingInterface
{
	/**
	 * Get the supplier
	 * 
	 * @return SupplierInterface
	 */
	public function getSupplier();
	
	/**
	 * Get ProductList
	 * 
	 * @return SupplierProductListInterface
	 */
	public function getProductList();
	
}