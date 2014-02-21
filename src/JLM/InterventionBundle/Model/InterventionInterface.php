<?php
namespace JLM\InterventionBundle\Model;

/**
 * InterventionInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface InterventionInterface
{
	/**
	 * Get the installation of the intervention
	 * 
	 * @return InstallationInterface
	 */
	public function getInstallation();
	
	/**
	 * Get contract
	 * 
	 * @return ContractInterface
	 */
	public function getContract();
	
	/**
	 * Get voucher
	 * 
	 * @return string
	 */
	public function getVoucher();
	
	/**
	 * Get the creation
	 *
	 * @return \DateTime
	 */
	public function getCreation();
	
	/**
	 * Get the close date
	 * 
	 * @return \DateTime
	 */
	public function getClose();
	
	/**
	 * Is close
	 * 
	 * @return bool
	 */
	public function isClose();
	
	/**
	 * Re-open the Intervention
	 * 
	 * @return self
	 */
	public function reOpen();
	
	/**
	 * Add a shifting
	 * 
	 * @param ShiftingInterface $shifting
	 * @return self
	 */
	public function addShifting(ShiftingInterface $shifting);
	
	/**
	 * Remove a shifting
	 *
	 * @param ShiftingInterface $shifting
	 * @return self
	 */
	public function removeShifting(ShiftingInterface $shifting);
	
	/**
	 * Get the shiftings
	 * 
	 * @return array
	 */
	public function getShiftings();
	
	/**
	 * Has planned shifting
	 * 
	 * @return bool
	 */
	public function isPlanned();
	
	/**
	 * Is ongoing
	 *
	 * @return bool
	 */
	public function isOngoing();
	
	/**
	 * Get the action
	 *
	 * @return string
	 */
	public function getAction();
	
	/**
	 * Get the rest to
	 *
	 * @return string
	*/
	public function getRest();
}