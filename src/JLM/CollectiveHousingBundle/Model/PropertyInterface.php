<?php
namespace JLM\CollectiveHousingBundle\Model;

/**
 * 
 * @author kwizer
 *
 */
interface PropertyInterface
{
	/**
	 * Get the address
	 */
	public function getAddress();
	
	/**
	 * @return bool
	 */
	public function isBlocked(); 
}