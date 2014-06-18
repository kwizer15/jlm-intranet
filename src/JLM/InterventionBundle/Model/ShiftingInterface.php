<?php
namespace JLM\InterventionBundle\Model;

use JLM\ContactBundle\Model\AddressInterface;

/**
 * ShiftingInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface ShiftingInterface
{
	/**
	 * Get the address of the shifting
	 * 
	 * @return AddressInterface
	 */
	public function getAddress();
	
	/**
	 * Get the Technician
	 * 
	 * @return TechnicianInterface
	 */
	public function getTechnician();
	
	/**
	 * Get the begin
	 * 
	 * @return \DateTime|null
	 */
	public function getBegin();
	
	/**
	 * Get the begin
	 *
	 * @return \DateTime|null
	 */
	public function getEnd();
}