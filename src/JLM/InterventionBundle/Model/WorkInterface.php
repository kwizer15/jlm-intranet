<?php
namespace JLM\InterventionBundle\Model;

/**
 * WorkInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface WorkInterface extends InterventionInterface
{
	/**
	 * Get list of products
	 * 
	 * @return WorkProductListInterface
	 */
	public function getProductList();
	
}