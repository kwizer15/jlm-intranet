<?php
namespace JLM\CollectiveHousingBundle\Model;

use JLM\ContactBundle\Model\PersonInterface;

interface UnionCouncilInterface
{
	/**
	 * Get the condominium
	 * 
	 * @return CondominiumInterface
	 */
	public function getCondominium();
	
	/**
	 * Add a part owner
	 * 
	 * @param PartOwnerInterface $partOwner
	 * @return self
	 */
	public function addPartOwner(PartOwnerInterface $partOwner);
	
	/**
	 * Remove a part owner
	 * 
	 * @param PartOwnerInterface $partOwner
	 * @return self
	 */
	public function removePartOwner(PartOwnerInterface $partOwner);
	
	/**
	 * Get part owners
	 * 
	 * @return array
	 */
	public function getPartOwners();
}