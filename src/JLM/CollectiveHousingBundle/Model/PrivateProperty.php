<?php
namespace JLM\CollectiveHousingBundle\Model;

interface PrivatePropertyInterface
{
	/**
	 * Get the owner
	 * 
	 * @return OwnerInterface
	 */
	public function getOwner();
	
	/**
	 * Set the owner
	 * 
	 * @param OwnerInterface $owner
	 * @return self
	 */
	public function setOwner(OwnerInterface $owner);
}