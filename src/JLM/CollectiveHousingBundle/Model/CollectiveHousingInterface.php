<?php
namespace JLM\CollectiveHousingBundle\Model;

interface CollectiveHousingInterface
{
	/**
	 * Add a resident
	 * 
	 * @param ResidentInterface
	 * @return self
	 */
	public function addResident(ResidentInterface $resident);
	
	/**
	 * Remove a resident
	 *
	 * @param ResidentInterface
	 * @return self
	 */
	public function removeResident(ResidentInterface $resident);
	
    /**
	 * Get the contacts
	 * @return array
	 */
	public function getResidents();
	
	/**
	 * Get the manager
	 * 
	 * @return ManagerInterface
	 */
	public function getManager();
	
	/**
	 * Set the manager
	 * 
	 * @param ManagerInterface
	 * @return self
	 */
	public function setManager(ManagerInterface $manager);
}