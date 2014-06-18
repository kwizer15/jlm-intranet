<?php
namespace JLM\InterventionBundle\Model;

/**
 * AuditInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface AuditShiftingInterface extends ShiftingInterface
{
	/**
	 * Get the installation
	 *
	 * @return IntallationInterface
	 */
	public function getInstallation();
	
	/**
	 * Get the reason
	 * 
	 * @return string
	 */
	public function getReason();
	
}