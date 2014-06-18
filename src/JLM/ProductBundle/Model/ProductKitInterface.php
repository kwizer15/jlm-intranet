<?php
namespace JLM\ProductBundle\Model;

interface ProductKitInterface extends ProductInterface
{
	/**
	 * Add sub-product
	 * 
	 * @param ProductInterface $product
	 * @return self
	 */
	public function addSubProduct(ProductInterface $product);
	
	/**
	 * Remove sub-product
	 *
	 * @param ProductInterface $product
	 * @return self
	 */
	public function removeSubProduct(ProductInterface $product);
	
	/**
	 * Get sub-products
	 * 
	 * @return array
	 */
	public function getSubProducts();
}